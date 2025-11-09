<?php
namespace App\Http\Controllers;

use App\Mail\RegistrationMail as RegistrationMail;
use App\Models\CustomerCards;
use App\Models\CustomerSubscription;
use App\Models\OnboardingDetails;
use App\Models\Product;
use App\Models\ProductFeatures;
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
            $errors = $validator->errors();

            if ($errors->has('email') || $errors->has('phone_number')) {
                session()->flash('emailPhoneError', 'The email or phone number is already registered.');
            }

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
        $features     = ProductFeatures::where("product_id", $subscription->product_id)->get();
        return view("payment", compact("subscription", "features"));
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
        return redirect()->route("customer.dashboard");
    }

    /**
     * websites
     *
     * @return void
     */
    public function websites()
    {
        $onboardingData = OnboardingDetails::updateOrCreate(
            [
                "user_id"   => Auth::user()->id,
                "operation" => "instruction"],
            [
                "completed" => true,
            ]
        );

        if ($onboardingData) {
            $data = OnboardingDetails::where("user_id", Auth::user()->id)->where("operation", "website 1")->first();
            return view("customer.onboarding.websites", compact("data"));
        } else {
            toast('Something Went Wrong.', 'error');
            return back();
        }
    }

    /**
     * storeWebsite
     *
     * @param Request request
     *
     * @return void
     */
    public function storeWebsite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'website_url'    => 'required',
            'admin_url'      => 'required',
            'admin_username' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $onboardingData = OnboardingDetails::updateOrCreate(
            [
                "user_id"   => Auth::user()->id,
                "operation" => "website 1"],
            [
                "website_url" => $request->website_url,
                "admin_url"   => $request->admin_url,
                "username"    => $request->admin_username,
                "completed"   => true,
            ]
        );

        if ($onboardingData) {
            return redirect()->route("onboarding.lastpass");
        } else {
            toast('Something Went Wrong.', 'error');
            return back();
        }
    }

    /**
     * additionalWebsites
     *
     * @param mixed id
     *
     * @return void
     */
    public function additionalWebsites($site)
    {
        if ($site <= 3) {
            $operation = "website " . $site;
            $data      = OnboardingDetails::where("user_id", Auth::user()->id)->where("operation", $operation)->first();
            return view("additional_websites", compact("data", "site"));
        } else {
            toast('Something Went Wrong.', 'error');
            return back();
        }
    }

    /**
     * storeAdditionalWebsite
     *
     * @param Request request
     *
     * @return void
     */
    public function storeAdditionalWebsite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'website_url'    => 'required',
            'admin_url'      => 'required',
            'admin_username' => 'required',
            'site'           => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $onboardingData = OnboardingDetails::updateOrCreate(
            [
                "user_id"   => Auth::user()->id,
                "operation" => "website " . $request->site,
            ],
            [
                "website_url" => $request->website_url,
                "admin_url"   => $request->admin_url,
                "username"    => $request->admin_username,
                "completed"   => true,
            ]
        );

        if ($onboardingData) {
            if ($request->site == 2) {
                $website = 3;
                return redirect()->route("onboarding.additionalWebsites", [$website]);
            } else {
                return redirect()->route("onboarding.lastpass");
            }

        } else {
            toast('Something Went Wrong.', 'error');
            return back();
        }
    }

    /**
     * completeOnboarding
     *
     * @param Request request
     *
     * @return void
     */
    public function completeOnboarding(Request $request)
    {
        $onboardingData = OnboardingDetails::updateOrCreate(
            [
                "user_id"   => Auth::user()->id,
                "operation" => "lastpass",
            ],
            [
                "completed" => true,
            ]
        );

        if ($onboardingData) {
            $user                    = Auth::user();
            $user->onboarding_status = "onboarded";
            $user->save();
            toast('Onboarding Completed Successfully.', 'success');
            return redirect()->route("customer.dashboard");
        } else {
            toast('Something Went Wrong.', 'error');
            return back();
        }
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
