<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CustomerOtp;
use Auth;
use Illuminate\Http\Request;
use Session;

class TwofactorController extends Controller
{
    public function verify2FA(Request $request)
    {

        $gaCode = $request->google2fa_code;

        $user      = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $valid     = $google2fa->verify($gaCode, Auth::user()->google2fa_secret);

        if ($valid) {
            $data = [
                'id'   => Auth::user()->id,
                'time' => now(),
            ];
            Session::put('myGoogle2fa', $data);

            return back();
        } else {
            return back()->with(['error' => "Something Went Wrong"]);
        }
    }

    public function validate2fa(Request $request)
    {
        $code = $request->confirmation_code;

        if (Auth::user()->auth_2fa == "Email") {
            $codeIsValid = CustomerOtp::where("user_id", Auth::user()->id)->where("otp", $code)->where("otp_type", "Email")->first();
            if (isset($codeIsValid)) {
                $codeIsValid->delete();
                $data = [
                    'id'   => Auth::user()->id,
                    'time' => now(),
                ];
                Session::put('myValid2fa', $data);
                return back();
            } else {
                return back()->with(['error' => "Something Went Wrong"]);
            }

        }
    }
}
