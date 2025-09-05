<?php
namespace App\Http\Controllers;

use App\Models\User;

class OnboardingController extends Controller
{
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
