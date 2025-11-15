<?php
namespace App\Http\Controllers;

use App\Mail\ClientInactivity as ClientInactivity;
use App\Mail\InactivityReminder as InactivityReminder;
use App\Mail\RenewalConfirmation as RenewalConfirmation;
use App\Mail\SubscriptionReminder as SubscriptionReminder;
use App\Models\CustomerCards;
use App\Models\CustomerSubscription;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mail;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CronController extends Controller
{
    /**
     * renewSubscription
     *
     * @return void
     */
    public function renewSubscription()
    {
        $today       = Carbon::today();
        $expiredSubs = CustomerSubscription::whereDate("expiry_date", $today)->get();
        // dd($expiredSubs);

        foreach ($expiredSubs as $plan) {

            $user = User::find($plan->user_id);
            $card = CustomerCards::where("user_id", $user->id)->where("default_card", 1)->first();

            if ($plan->frequency == "yearly") {
                $duration = 12;
            } else if ($plan->frequency == "quarterly") {
                $duration = 3;
            } else {
                $duration = 1;
            }

            try {

                Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                $paymentIntent = PaymentIntent::create([
                    'customer'       => $user->stripe_customer_id,
                    'amount'         => ($plan->pricing * 100),
                    'currency'       => 'gbp',
                    'payment_method' => $card->authorization_code,
                    'off_session'    => true,
                    'confirm'        => true,
                ]);

                if (isset($paymentIntent->status) && $paymentIntent->status == "succeeded") {

                    DB::beginTransaction();

                    $pm = "Credit Card (" . ucwords($card->card_brand) . " ****-****-****-" . $card->last_four_digits . ")";

                    $invoice                 = new Invoice;
                    $invoice->user_id        = $user->id;
                    $invoice->product_id     = $plan->product_id;
                    $invoice->plan_id        = $plan->plan_id;
                    $invoice->due_date       = Carbon::now()->addDays(5);
                    $invoice->amount         = $plan->pricing;
                    $invoice->payment_method = $pm;
                    $invoice->txn_id         = "TXN" . preg_replace("/pi/", "", $paymentIntent->id);
                    $invoice->status         = "paid";
                    $invoice->save();

                    $subscription                 = new CustomerSubscription;
                    $subscription->user_id        = $user->id;
                    $subscription->invoice_id     = $invoice->id;
                    $subscription->product_id     = $plan->product_id;
                    $subscription->plan_id        = $plan->plan_id;
                    $subscription->pricing        = $plan->pricing;
                    $subscription->effective_date = now();
                    $subscription->expiry_date    = Carbon::now()->addMonths($duration);
                    $subscription->save();

                    $plan->status == "terminated";
                    $plan->save();

                    DB::commit();

                    try {
                        Mail::to($user)->send(new RenewalConfirmation($user, $subscription));
                    } catch (\Exception $e) {
                        report($e);
                    }

                } else {
                    DB::rollback();

                    toast('We are unable to charge this payment method at this time. Please try again later.', 'error');
                    return back();
                }
            } catch (CardException $e) {
                DB::rollback();
                // Card was declined
                report($e->getMessage());

            } catch (InvalidRequestException $e) {
                DB::rollback();
                // Wrong params (e.g., wrong payment method ID)
                report($e->getMessage());

            } catch (ApiErrorException $e) {
                DB::rollback();
                // Any other Stripe API error
                report($e->getMessage());
            } catch (\Throwable $e) {
                DB::rollback();
                // Any Code Related Error That is not Stripe Generated
                report($e->getMessage());
            }
        }

    }

    /**
     * expiringSubscription
     *
     * @return void
     */
    public function expiringSubscription()
    {
        $expiringSubs = CustomerSubscription::whereDate('expiry_date', now()->addDays(7))
            ->orWhereDate('expiry_date', now()->addDays(14))
            ->get();

        foreach ($expiringSubs as $subscription) {

            try {
                $user = User::find($subscription->user_id);
                Mail::to($user)->send(new SubscriptionReminder($user, $subscription));
            } catch (\Exception $e) {
                report($e);
            }

        }
    }

    /**
     * inactiveClients
     *
     * @return void
     */
    public function inactiveClients()
    {
        $inactiveClients = User::where("role_id", 0)
            ->whereHas('tasks') // must have at least 1 task ever
            ->whereHas('latestTask', function ($q) {
                $q->where('created_at', '<', now()->subDays(30)); // last task older than 30 days
            })
            ->with('latestTask')
            ->get();

        foreach ($inactiveClients as $user) {

            $lastTaskDate = $user->latestTask ? $user->latestTask->created_at : null;
            $inactiveDays = $lastTaskDate
                ? now()->diffInDays($lastTaskDate)
                : 30;

            try {
                $admin = env("ADMIN_MAIL");
                Mail::to($admin)->send(new ClientInactivity($user, $inactiveDays));
                Mail::to($user)->send(new InactivityReminder($user));
            } catch (\Exception $e) {
                report($e);
            }

        }
    }
}
