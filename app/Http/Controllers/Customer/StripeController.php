<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\RenewalConfirmation as RenewalConfirmation;
use App\Models\CustomerCards;
use App\Models\CustomerSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\SetupIntent;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeController extends Controller
{
    /**
     * initiateCardAddition
     *
     * @return void
     */
    public function initiateCardAddition()
    {

        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            if (! isset(Auth::user()->stripe_customer_id)) {
                // Create Customer on Stripe
                $customer = Customer::create([
                    'email' => Auth::user()->email,
                    'name'  => Auth::user()->last_name . " " . Auth::user()->other_names,
                ]);

                // Save Customer in DB
                $user                     = Auth::user();
                $user->stripe_customer_id = $customer->id;
                $user->save();
            }

            $user = User::find(Auth::user()->id);

            $intent = SetupIntent::create([
                'customer' => $user->stripe_customer_id,
            ]);

            return view('customer.payment', ['intent' => $intent]);
        } catch (\Throwable $e) {
            report($e);
            toast($e->getMessage(), 'error');
            return back();
        }
    }

    /**
     * savePaymentMethod
     *
     * @param Request request
     *
     * @return void
     */
    public function savePaymentMethod(Request $request)
    {
        try {
            $user = Auth::user();

            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

            $paymentMethodId = $request->payment_method;
            $paymentMethod   = $stripe->paymentMethods->retrieve($paymentMethodId);

            $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $user->stripe_customer_id]
            );

            DB::beginTransaction();
            $card                     = new CustomerCards;
            $card->user_id            = Auth::user()->id;
            $card->authorization_code = $paymentMethodId;
            $card->last_four_digits   = $paymentMethod->card->last4;
            $card->expiry_month       = $paymentMethod->card->exp_month;
            $card->expiry_year        = $paymentMethod->card->exp_year;
            $card->card_brand         = $paymentMethod->card->brand;
            $card->save();

            $user->stripe_payment_method = $paymentMethodId;
            $user->save();

            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            return response()->json(['success' => false]);
        }
    }

    /**
     * pmSuccess
     *
     * @return void
     */
    public function pmSuccess()
    {
        toast('Payment Method Added Successfully.', 'success');
        return redirect()->route("customer.billing");
    }

    /**
     * renewSubscription
     *
     * @return void
     */
    public function renewSubscription($planId, $cardId)
    {
        $user = Auth::user();
        $card = CustomerCards::find($cardId);
        $plan = SubscriptionPlan::find($planId);

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

                toast('Your Plan has been successfully renewed.', 'success');
                return back();
            } else {
                DB::rollback();
                toast('We are unable to charge this payment method at this time. Please try again later.', 'error');
                return back();
            }
        } catch (CardException $e) {
            DB::rollback();
            // Card was declined
            toast($e->getMessage(), 'error');
            return back();

        } catch (InvalidRequestException $e) {
            DB::rollback();
            // Wrong params (e.g., wrong payment method ID)
            toast("There appears to be an issue with the selected payment method.", 'error');
            return back();

        } catch (ApiErrorException $e) {
            DB::rollback();
            // Any other Stripe API error
            toast($e->getMessage(), 'error');
            return back();
        } catch (\Throwable $e) {
            DB::rollback();
            // Any Code Related Error That is not Stripe Generated
            toast($e->getMessage(), 'error');
            return back();
        }
    }

}
