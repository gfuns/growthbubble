<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\SetupIntent;
use Stripe\Stripe;

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
        $paymentMethodId = $request->payment_method;

        $user                        = Auth::user();
        $user->stripe_payment_method = $paymentMethodId;
        if ($user->save()) {
            return response()->json(['success' => true]);
        } else {
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
    public function renewSubscription()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $paymentIntent = PaymentIntent::create([
            'customer'       => $user->stripe_customer_id,
            'amount'         => 5000, // in kobo/cent (₦50.00)
            'currency'       => 'usd',
            'payment_method' => $user->stripe_payment_method,
            'off_session'    => true,
            'confirm'        => true,
        ]);

        return $paymentIntent;
    }

}
