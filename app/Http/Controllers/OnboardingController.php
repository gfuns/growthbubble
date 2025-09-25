<?php
namespace App\Http\Controllers;

use App\Mail\RegistrationMail as RegistrationMail;
use App\Models\CustomerCards;
use App\Models\CustomerSubscription;
use App\Models\Product;
use App\Models\SubscriptionInfo;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\StripeClient;

class OnboardingController extends Controller
{

    /**
     * customerCheckout
     *
     * @return void
     */
    public function customerCheckout()
    {
        $package  = request()->product;
        $bouquet  = request()->plan;
        $duration = request()->duration;

        $product = Product::where("product", $package)->first();
        if (isset($package)) {
            $plan = SubscriptionPlan::where("product_id", $product->id)->where("plan", $bouquet)->where("frequency", $duration)->first();
            if (isset($plan)) {
                return view("checkout", compact("product", "plan"));
            } else {
                return redirect()->away('https://growthbubbles.com');
            }
        }

        return redirect()->away('https://growthbubbles.com');

    }

    /**
     * customerOnboarding
     *
     * @param Request request
     *
     * @return void
     */
    public function customerOnboarding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name'         => 'required',
            'first_name'        => 'required',
            'email'             => 'required|unique:users',
            'phone_number'      => 'required|unique:users',
            'organization_name' => 'required',
            'password'          => 'required',
            'referral_channel'  => 'required',
            'product'           => 'required',
            'plan'              => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        try {

            DB::beginTransaction();

            $customer                    = new User;
            $customer->last_name         = $request->last_name;
            $customer->other_names       = $request->first_name;
            $customer->email             = $request->email;
            $customer->phone_number      = $request->phone_number;
            $customer->password          = Hash::make($request->password);
            $customer->role_id           = 0;
            $customer->organization      = ucwords(strtolower($request->organization_name));
            $customer->token             = Str::random(60);
            $customer->onboarding_status = "awaiting payment";
            $customer->save();

            $subscription             = new SubscriptionInfo;
            $subscription->user_id    = $customer->id;
            $subscription->product_id = $request->product;
            $subscription->plan_id    = $request->plan;
            $subscription->save();

            DB::commit();

            Auth::login($customer); // Logs in the user

            try {
                Mail::to($customer)->send(new RegistrationMail($customer));
            } catch (\Exception $e) {
                report($e);
            } finally {
                return redirect()->route("onboarding.payment");
            }
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();

            toast('Something went wrong. Please try again', 'error');
            return back();
        }

    }

    /**
     * subscriptionPayment
     *
     * @return void
     */
    public function subscriptionPayment()
    {
        $subscription = SubscriptionInfo::where("user_id", Auth::user()->id)->first();
        return view("payment");
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

            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $customer = Customer::create([
                'email' => Auth::user()->email,
                'name'  => Auth::user()->last_name . " " . Auth::user()->other_names,
            ]);

            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

            $paymentMethodId = $request->payment_method;
            $paymentMethod   = $stripe->paymentMethods->retrieve($paymentMethodId);

            $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $customer->id]
            );

            $tempData = SubscriptionInfo::where("user_id", $user->id)->first();

            $plan = SubscriptionPlan::find($tempData->plan_id);

            $paymentIntent = PaymentIntent::create([
                'customer'       => $customer->id,
                'amount'         => ($plan->pricing * 100),
                'currency'       => 'gbp',
                'payment_method' => $paymentMethodId,
                'off_session'    => true,
                'confirm'        => true,
            ]);

            if ($plan->frequency == "yearly") {
                $duration = 12;
            } else if ($plan->frequency == "quarterly") {
                $duration = 3;
            } else {
                $duration = 1;
            }

            if (isset($paymentIntent->status) && $paymentIntent->status == "succeeded") {

                DB::beginTransaction();

                $user->country               = $request->country;
                $user->contact_address       = $request->address;
                $user->onboarding_status     = "pending";
                $user->stripe_customer_id    = $customer->id;
                $user->stripe_payment_method = $paymentMethodId;
                $user->save();

                $subscription                 = new CustomerSubscription;
                $subscription->user_id        = $user->id;
                $subscription->product_id     = $plan->product_id;
                $subscription->plan_id        = $plan->id;
                $subscription->pricing        = $plan->pricing;
                $subscription->effective_date = now();
                $subscription->expiry_date    = Carbon::now()->addMonths($duration);
                $subscription->save();

                $card                     = new CustomerCards;
                $card->user_id            = $user->id;
                $card->authorization_code = $paymentMethodId;
                $card->last_four_digits   = $paymentMethod->card->last4;
                $card->expiry_month       = $paymentMethod->card->exp_month;
                $card->expiry_year        = $paymentMethod->card->exp_year;
                $card->card_brand         = $paymentMethod->card->brand;
                $card->default_card       = 1;
                $card->save();

                DB::commit();

                $tempData->delete();

                return response()->json(['success' => true]);

            } else {
                return response()->json(['success' => false]);
            }
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
        return redirect()->route("onboarding.instructions");
    }

    /**
     * verifyWithLink
     *
     * @param mixed token
     *
     * @return void
     */
    public function verifyWithLink($token)
    {
        $user = User::where("token", $token)->first();
        if (isset($user)) {
            $user->email_verified_at = now();
            $user->token             = null;
            $user->save();

            $status = "Successful";

            return view("verification_status", compact("status"));
        } else {
            $status = "Failed";
            return view("verification_status", compact("status"));
        }
    }

}
