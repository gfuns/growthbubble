<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountCreationMail as AccountCreationMail;
use App\Mail\CustomerCreationMail as CustomerCreationMail;
use App\Models\PlatformFeature;
use App\Models\Product;
use App\Models\SubscriptionPlan;
use App\Models\TaskCategory;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use Auth;
use Carbon\Carbon;
use Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mail;
use Session;

class AdminController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $params = [
            "regs"     => 0,
            "renewals" => 0,
            "poas"     => 0,
            "awards"   => 0,
            "prFees"   => 0,
        ];

        $year   = Carbon::now()->year;
        $months = collect(range(1, 12));

        $datasets = [
            'registrations' => [],
            'renewals'      => [],
            'poa'           => [],
            'award_letters' => [],
            'processing'    => [],
        ];

        foreach ($months as $m) {
            $datasets['registrations'][] = 0;

            $datasets['renewals'][] = 0;

            $datasets['poa'][] = 0;

            $datasets['award_letters'][] = 0;

            $datasets['processing'][] = 0;
        }

        $dataSets = json_encode($datasets);

        return view("admin.dashboard", compact("params", "dataSets"));
    }

    /**
     * profile
     *
     * @return void
     */
    public function viewProfile()
    {
        return view("admin.profile");
    }

    /**
     * updateProfile
     *
     * @param Request request
     *
     * @return void
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name'     => 'required',
            'other_names'   => 'required',
            'phone_number'  => 'required',
            'profile_photo' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $state = Auth::user()->profile_updated;

        $parseEmail = User::where("email", $request->email)->where("id", "!=", Auth::user()->id)->count();
        if ($parseEmail > 0) {
            toast('Email already used by someone else.', 'error');
            return back();
        }

        $parsePhone = User::where("email", $request->phone_number)->where("id", "!=", Auth::user()->id)->count();
        if ($parsePhone > 0) {
            toast('Phone number already used by someone else.', 'error');
            return back();
        }

        $user                  = Auth::user();
        $user->last_name       = $request->last_name;
        $user->other_names     = $request->other_names;
        $user->phone_number    = $request->phone_number;
        $user->profile_updated = 1;
        if ($request->has('profile_photo')) {
            $uploadedFileUrl     = Cloudinary::upload($request->file('profile_photo')->getRealPath())->getSecurePath();
            $user->profile_photo = $uploadedFileUrl;
        }

        if ($user->save()) {
            toast('Profile Information Successfully Updated.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }

    }

    /**
     * updatePassword
     *
     * @param Request request
     *
     * @return void
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'          => 'required',
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

        if (! Hash::check($request->current_password, $user->password)) {
            toast('Invalid current password provided.', 'error');
            return back();
        } else {
            if ($request->new_password != $request->new_password_confirmation) {
                toast('Your newly seleted passwords do not match.', 'error');
                return back();
            } else {
                $user->password = Hash::make($request->new_password);
                $user->save();
            }
        }

        if ($user->save()) {
            toast('Password Successfully Updated.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }

    }

    /**
     * security
     *
     * @return void
     */
    public function security()
    {
        $google2fa       = app('pragmarx.google2fa');
        $google2faSecret = $google2fa->generateSecretKey();
        $QRImage         = $google2fa->getQRCodeInline(
            env('APP_NAME'),
            Auth::user()->email,
            $google2faSecret
        );
        return view("admin.security", compact("google2faSecret", "QRImage"));
    }

    /**
     * enableGA
     *
     * @param Request request
     *
     * @return void
     */
    public function enableGA(Request $request)
    {
        $gaCode   = $request->google2fa_code;
        $gaSecret = $request->google2fa_secret;

        if ($gaCode == null || $gaSecret == null) {
            toast('Please enter a valid Google 2FA Code.', 'error');
            return back();
        }

        $user      = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $valid     = $google2fa->verifyKey($gaSecret, $gaCode);

        if ($valid) {
            $user->google2fa_secret = $gaSecret;
            if ($user->save()) {
                toast('Successfully Enabled Google Authenticator on your account', 'success');
                return back();
            } else {
                toast('Something went wrong.', 'error');
                return back();
            }

        } else {
            toast('Invalid Google 2FA Code.', 'error');
            return back();

        }

    }

    /**
     * select2FA
     *
     * @param Request request
     *
     * @return void
     */
    public function select2FA(Request $request)
    {

        $user = Auth::user();

        if ($request->param == "google_auth2fa") {
            if (isset($user->google2fa_secret) && $request->status == 1) {
                $data = [
                    'id'   => Auth::user()->id,
                    'time' => now(),
                ];
                Session::put('myGoogle2fa', $data);
                $user->auth_2fa = "GoogleAuth";
            } else if (isset($user->google2fa_secret) && $request->status == 0) {
                $user->auth_2fa = null;
                Session::forget('myGoogle2fa');
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Please Setup Google Authenticator to be able to enable this option.',
                ]);
            }
        }

        if ($request->param == "email_auth2fa") {
            if ($request->status == 1) {
                $user->auth_2fa = "Email";
                $data           = [
                    'id'   => Auth::user()->id,
                    'time' => now(),
                ];
                Session::put('myValid2fa', $data);
            } else {
                $user->auth_2fa = null;
                Session::forget('myValid2fa');
            }
        }

        if ($user->save()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Authentication 2FA Method Updated Successfully',
            ]);
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong! Please try again',
            ]);
        }

    }

    /**
     * platformFeatures
     *
     * @return void
     */
    public function platformFeatures()
    {
        $platformFeatures = PlatformFeature::all();
        return view("admin.platform_features", compact("platformFeatures"));
    }

    /**
     * userRoles
     *
     * @return void
     */
    public function userRoles()
    {
        $userRoles = UserRole::where("id", ">", 1)->get();
        return view("admin.role_management", compact("userRoles"));
    }

    /**
     * storeUserRole
     *
     * @param Request request
     *
     * @return void
     */
    public function storeUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|unique:user_roles',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $userRole       = new UserRole;
        $userRole->role = $request->role;
        if ($userRole->save()) {
            toast('User Role Created Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * updateUserRole
     *
     * @param Request request
     *
     * @return void
     */
    public function updateUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'role'    => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $userRole       = UserRole::find($request->role_id);
        $userRole->role = $request->role;
        if ($userRole->save()) {
            toast('User Role Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * staffManagement
     *
     * @return void
     */
    public function staffManagement()
    {
        $status    = request()->status;
        $search    = request()->search;
        $userRoles = UserRole::where("id", ">", 1)->get();

        $query = User::query();

        $query->where("role_id", ">", 0);

        if (isset(request()->search)) {
            $query->whereLike(["last_name", "other_names", "email", "phone_number"], $search);
        }

        if (isset(request()->status)) {
            $query->where("status", $status);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $staffList  = $query->paginate(50);

        return view("admin.staff_management", compact('staffList', 'userRoles', 'status', 'search'));
    }

    /**
     * storeStaff
     *
     * @param Request request
     *
     * @return void
     */
    public function storeStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name'    => 'required',
            'first_name'   => 'required',
            'email'        => 'required|unique:users',
            'phone_number' => 'required|unique:users',
            'role'         => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $user               = new User;
        $user->last_name    = $request->last_name;
        $user->other_names  = $request->first_name;
        $user->email        = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password     = Hash::make($request->phone_number);
        $user->role_id      = $request->role;
        $user->token        = Str::random(60);
        if ($user->save()) {
            try {
                Mail::to($user)->send(new AccountCreationMail($user, $user->phone_number));
            } catch (\Exception $e) {
                report($e);
            }
            toast('Staff Information Stored Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateStaff
     *
     * @param Request request
     *
     * @return void
     */
    public function updateStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required',
            'first_name'   => 'required',
            'last_name'    => 'required',
            'email'        => 'required',
            'phone_number' => 'required',
            'role'         => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $emailTaken = User::where("id", "!=", $request->user_id)->where("email", $request->email)->first();
        if (isset($emailTaken)) {
            toast('This Email Has Already Been Taken By Another Staff.', 'error');
            return back();
        }

        $phoneTaken = User::where("id", "!=", $request->user_id)->where("phone_number", $request->phone_number)->first();
        if (isset($phoneTaken)) {
            toast('This Phone Number Has Already Been Taken By Another Staff.', 'error');
            return back();
        }

        $user               = User::find($request->user_id);
        $user->last_name    = $request->last_name;
        $user->other_names  = $request->first_name;
        $user->email        = $request->email;
        $user->phone_number = $request->phone_number;
        $user->role_id      = $request->role;
        if ($user->save()) {
            toast('Staff Information Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * suspendStaff
     *
     * @param mixed id
     *
     * @return void
     */
    public function suspendStaff($id)
    {
        $user         = User::find($id);
        $user->status = "suspended";
        if ($user->save()) {
            toast('Staff Account Suspended Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * activateStaff
     *
     * @param mixed id
     *
     * @return void
     */
    public function activateStaff($id)
    {
        $user         = User::find($id);
        $user->status = "active";
        if ($user->save()) {
            toast('Staff Account Activated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * managePermissions
     *
     * @param mixed id
     *
     * @return void
     */
    public function managePermissions($id)
    {
        $role             = UserRole::find($id);
        $platformFeatures = PlatformFeature::all();
        return view("admin.permissions", compact("role", "platformFeatures"));
    }

    /**
     * grantFeaturePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantFeaturePermission($role, $feature)
    {
        $permission             = new UserPermission;
        $permission->role_id    = $role;
        $permission->feature_id = $feature;
        if ($permission->save()) {
            toast('Feature Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeFeaturePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeFeaturePermission($role, $feature)
    {
        $permission = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        if ($permission->delete()) {
            toast('Feature Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * grantCreatePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantCreatePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_create = 1;
        if ($permission->save()) {
            toast('Can Create Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeCreatePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeCreatePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_create = 0;
        if ($permission->save()) {
            toast('Can Create Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * grantEditPermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantEditPermission($role, $feature)
    {
        $permission           = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_edit = 1;
        if ($permission->save()) {
            toast('Can Edit Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeEditPermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeEditPermission($role, $feature)
    {
        $permission           = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_edit = 0;
        if ($permission->save()) {
            toast('Can Edit Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * grantDeletePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function grantDeletePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_delete = 1;
        if ($permission->save()) {
            toast('Can Delete Permission Granted', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * revokeDeletePermission
     *
     * @param mixed role
     * @param mixed feature
     *
     * @return void
     */
    public function revokeDeletePermission($role, $feature)
    {
        $permission             = UserPermission::where("role_id", $role)->where("feature_id", $feature)->first();
        $permission->can_delete = 0;
        if ($permission->save()) {
            toast('Can Delete Permission Revoked', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * productManagement
     *
     * @return void
     */
    public function productManagement()
    {
        $products = Product::all();
        return view("admin.product_management", compact("products"));
    }

    /**
     * storeProduct
     *
     * @param Request request
     *
     * @return void
     */
    public function storeProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name'        => 'required',
            'product_description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $product              = new Product;
        $product->product     = $request->product_name;
        $product->description = $request->product_description;
        if ($product->save()) {
            toast('Product Information Added Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * updateProduct
     *
     * @param Request request
     *
     * @return void
     */
    public function updateProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'          => 'required',
            'product_name'        => 'required',
            'product_description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $product              = Product::find($request->product_id);
        $product->product     = $request->product_name;
        $product->description = $request->product_description;
        if ($product->save()) {
            toast('Product Information Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * productPlans
     *
     * @return void
     */
    public function productPlans()
    {
        $products     = Product::all();
        $productPlans = SubscriptionPlan::all();
        return view("admin.product_plans", compact("productPlans", "products"));
    }

    /**
     * storeProductPlan
     *
     * @param Request request
     *
     * @return void
     */
    public function storeProductPlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product'   => 'required',
            'plan'      => 'required',
            'frequency' => 'required',
            'pricing'   => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $plan             = new SubscriptionPlan;
        $plan->product_id = $request->product;
        $plan->plan       = $request->plan;
        $plan->frequency  = $request->frequency;
        $plan->pricing    = $request->pricing;
        if ($plan->save()) {
            toast('Product Plan Added Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * updateProductPlan
     *
     * @param Request request
     *
     * @return void
     */
    public function updateProductPlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plan_id'   => 'required',
            'product'   => 'required',
            'plan'      => 'required',
            'frequency' => 'required',
            'pricing'   => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $plan             = SubscriptionPlan::find($request->plan_id);
        $plan->product_id = $request->product;
        $plan->plan       = $request->plan;
        $plan->frequency  = $request->frequency;
        $plan->pricing    = $request->pricing;
        if ($plan->save()) {
            toast('Product Plan Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * registeredCustomers
     *
     * @return void
     */
    public function registeredCustomers()
    {
        $status = request()->status;
        $search = request()->search;

        $query = User::query();

        $query->where("role_id", 0);

        if (isset(request()->search)) {
            $query->whereLike(["last_name", "other_names", "email", "phone_number"], $search);
        }

        if (isset(request()->status)) {
            $query->where("status", $status);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $customers  = $query->paginate(50);

        return view("admin.registered_customers", compact('customers', 'status', 'search'));
    }

    /**
     * storeCustomer
     *
     * @param Request request
     *
     * @return void
     */
    public function storeCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name'         => 'required',
            'first_name'        => 'required',
            'email'             => 'required|unique:users',
            'phone_number'      => 'required|unique:users',
            'organization_name' => 'nullable',
            'contact_address'   => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $customer                  = new User;
        $customer->last_name       = $request->last_name;
        $customer->other_names     = $request->first_name;
        $customer->email           = $request->email;
        $customer->phone_number    = $request->phone_number;
        $customer->password        = Hash::make($request->phone_number);
        $customer->role_id         = 0;
        $customer->organization    = ucwords(strtolower($request->organization_name));
        $customer->contact_address = $request->contact_address;
        $customer->token           = Str::random(60);
        if ($customer->save()) {
            try {
                Mail::to($customer)->send(new CustomerCreationMail($customer, $customer->phone_number));
            } catch (\Exception $e) {
                report($e);
            }
            toast('Customer Account Created Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateCustomer
     *
     * @param Request request
     *
     * @return void
     */
    public function updateCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id'       => 'required',
            'last_name'         => 'required',
            'first_name'        => 'required',
            'email'             => 'required',
            'phone_number'      => 'required',
            'organization_name' => 'nullable',
            'contact_address'   => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $emailTaken = User::where("id", "!=", $request->customer_id)->where("email", $request->email)->first();
        if (isset($emailTaken)) {
            toast('This Email Has Already Been Taken By Another Customer.', 'error');
            return back();
        }

        $phoneTaken = User::where("id", "!=", $request->customer_id)->where("phone_number", $request->phone_number)->first();
        if (isset($phoneTaken)) {
            toast('This Phone Number Has Already Been Taken By Another Customer.', 'error');
            return back();
        }

        $customer                  = User::find($request->customer_id);
        $customer->last_name       = $request->last_name;
        $customer->other_names     = $request->first_name;
        $customer->email           = $request->email;
        $customer->phone_number    = $request->phone_number;
        $customer->password        = Hash::make($request->phone_number);
        $customer->organization    = ucwords(strtolower($request->organization_name));
        $customer->contact_address = $request->contact_address;
        $customer->token           = Str::random(60);
        if ($customer->save()) {
            toast('Customer Information Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * suspendCustomer
     *
     * @param mixed id
     *
     * @return void
     */
    public function suspendCustomer($id)
    {
        $user         = User::find($id);
        $user->status = "suspended";
        if ($user->save()) {
            toast('Customer Account Suspended Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * activateCustomer
     *
     * @param mixed id
     *
     * @return void
     */
    public function activateCustomer($id)
    {
        $user         = User::find($id);
        $user->status = "active";
        if ($user->save()) {
            toast('Customer Account Activated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * taskCategories
     *
     * @return void
     */
    public function taskCategories()
    {
        $taskcategories = TaskCategory::all();
        return view("admin.task_categories", compact("taskcategories"));
    }

    /**
     * storeTaskCategory
     *
     * @param Request request
     *
     * @return void
     */
    public function storeTaskCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $category           = new TaskCategory;
        $category->category = $request->category;
        if ($category->save()) {
            toast('Task Category Created Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * updateTaskCategory
     *
     * @param Request request
     *
     * @return void
     */
    public function updateTaskCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'category'    => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $category           = TaskCategory::find($request->category_id);
        $category->category = $request->category;
        if ($category->save()) {
            toast('Task Category Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * getMarkers Helper Function
     *
     * @param mixed lastRecord
     * @param mixed pageNum
     *
     * @return void
     */
    public function getMarkers($lastRecord, $pageNum)
    {
        if ($pageNum == null) {
            $pageNum = 1;
        }
        $end    = (50 * ((int) $pageNum));
        $marker = [];
        if ((int) $pageNum == 1) {
            $marker["begin"] = (int) $pageNum;
            $marker["index"] = (int) $pageNum;
        } else {
            $marker["begin"] = number_format(((50 * ((int) $pageNum)) - 49), 0);
            $marker["index"] = number_format(((50 * ((int) $pageNum)) - 49), 0);
        }

        if ($end > $lastRecord) {
            $marker["end"] = number_format($lastRecord, 0);
        } else {
            $marker["end"] = number_format($end, 0);
        }

        return $marker;
    }

}
