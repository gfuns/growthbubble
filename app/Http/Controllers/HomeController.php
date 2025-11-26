<?php
namespace App\Http\Controllers;

use App\Mail\AuthenticationOTP as AuthenticationOTP;
use App\Models\CustomerOtp;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        try {
            if (Auth::user()->auth_2fa == "Email") {
                if ($otp = CustomerOtp::updateOrCreate(
                    [
                        'user_id'  => Auth::user()->id,
                        'otp_type' => Auth::user()->auth_2fa,
                    ], [
                        'otp'            => $this->generateTFA(),
                        'otp_expiration' => Carbon::now()->addMinutes(10),
                    ])) {

                    $user = Auth::user();
                    Mail::to($user)->send(new AuthenticationOTP($user, $otp));

                }

            }

        } catch (\Exception $e) {
            report($e);
        } finally {
            if (Auth::user()->userRole->role_type == "administrator") {
                return redirect()->route("admin.dashboard");
            } else {
                return redirect()->route("customer.dashboard");
            }
        }

    }

    public function generateTFA()
    {
        $pin = range(0, 9);
        $set = shuffle($pin);
        $otp = "";
        for ($i = 0; $i < 6; $i++) {
            $otp = $otp . "" . $pin[$i];
        }

        return $otp;
    }

    public function changeDefaultPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'default_password'          => 'required',
            'new_password'              => 'required',
            'new_password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $user = Auth::user();

        if (! Hash::check($request->default_password, $user->password)) {
            toast('Invalid default password provided.', 'error');
            return back();
        } else {
            if ($request->new_password != $request->new_password_confirmation) {
                toast('Your seleted passwords do not match.', 'error');
                return back();
            } else {
                $user->password = Hash::make($request->new_password);
                $user->fpu      = null;
                $user->save();
            }
        }

        if ($user->save()) {
            toast('Password Successfully Updated.', 'success');
            return redirect()->route("admin.dashboard");
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

}
