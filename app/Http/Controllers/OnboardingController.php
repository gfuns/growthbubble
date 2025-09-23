<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\Models\User;

class OnboardingController extends Controller
{

    public function customerCheckout()
    {
        $product  = request()->product;
        $plan     = request()->plan;
        $duration = request()->duration;

        $package = Product::where("product", $product)->first();
        if (isset($package)) {
            $bouquet = SubscriptionPlan::where("product_id", $package->id)->where("plan", $plan)->where("frequency", $duration)->first();
            if (isset($bouquet)) {
                $description = "You are opting to purchase the " . ucwords($product) . " Product - " . ucwords($plan) . " Plan billable " . ucwords($duration);
                return view("checkout", compact("description"));
            } else {
                dd("Product Plan Not Found");
            }
        }

        dd("Product Not Found");

    }

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
