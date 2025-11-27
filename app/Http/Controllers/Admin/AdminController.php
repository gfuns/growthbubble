<?php
namespace App\Http\Controllers\Admin;

use App\Exports\ExportInvoice;
use App\Http\Controllers\Controller;
use App\Mail\AccountCreationMail as AccountCreationMail;
use App\Mail\CreatorTaskConfirmation as CreatorTaskConfirmation;
use App\Mail\CustomerCreationMail as CustomerCreationMail;
use App\Mail\InternalTaskCompletion as InternalTaskCompletion;
use App\Mail\OwnerTaskNotification as OwnerTaskNotification;
use App\Mail\PriorityPaymentConfirmation as PriorityPaymentConfirmation;
use App\Mail\TaskAssigned as TaskAssigned;
use App\Mail\TaskCompletion as TaskCompletion;
use App\Mail\TaskInProgress as TaskInProgress;
use App\Mail\TaskRevision as TaskRevision;
use App\Models\CustomerCards;
use App\Models\CustomerFiles;
use App\Models\CustomerSubscription;
use App\Models\CustomerTasks;
use App\Models\CustomerTickets;
use App\Models\Invoice;
use App\Models\OnboardingDetails;
use App\Models\PlatformActivities;
use App\Models\PlatformFeature;
use App\Models\Product;
use App\Models\ProductFeatures;
use App\Models\Project;
use App\Models\SubscriptionPlan;
use App\Models\TaskActivities;
use App\Models\TaskCategory;
use App\Models\TaskConversation;
use App\Models\TicketResponses;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserRole;
use Auth;
use Carbon\Carbon;
use Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class AdminController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        if (Auth::user()->role_id == 1) {
            $params = [
                "activeTasks"    => CustomerTasks::where("status", "in progress")->count(),
                "queuedTasks"    => CustomerTasks::where("status", "queued")->count(),
                "recurringTasks" => CustomerTasks::where("recurring", "yes")->count(),
                "completedTasks" => CustomerTasks::where("status", "completed")->count(),
                "cancelledTasks" => CustomerTasks::where("status", "cancelled")->count(),
                "onHoldTasks"    => CustomerTasks::where("status", "on hold")->count(),
            ];

            $products   = Product::orderBy("id", "desc")->limit(10)->get();
            $tasks      = CustomerTasks::orderBy("id", "desc")->limit(10)->get();
            $activities = PlatformActivities::orderBy("id", "desc")->limit(15)->get();
            return view("admin.dashboard", compact("params", "products", "tasks", "activities"));
        } else {
            $params = [
                "assignedTasks"  => CustomerTasks::where("assigned_to", Auth::user()->id)->count(),
                "activeTasks"    => CustomerTasks::where("assigned_to", Auth::user()->id)->where("status", "in progress")->count(),
                "recurringTasks" => CustomerTasks::where("assigned_to", Auth::user()->id)->where("recurring", "yes")->count(),
                "completedTasks" => CustomerTasks::where("assigned_to", Auth::user()->id)->where("status", "completed")->count(),
                "cancelledTasks" => CustomerTasks::where("assigned_to", Auth::user()->id)->where("status", "cancelled")->count(),
                "onHoldTasks"    => CustomerTasks::where("assigned_to", Auth::user()->id)->where("status", "on hold")->count(),
            ];

            $tasks = CustomerTasks::where("assigned_to", Auth::user()->id)->get();
            return view("admin.dashboard_staff", compact("params", "tasks"));
        }

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

        $password = Str::random(10);

        $user               = new User;
        $user->last_name    = $request->last_name;
        $user->other_names  = $request->first_name;
        $user->email        = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password     = Hash::make($password);
        $user->role_id      = $request->role;
        $user->token        = Str::random(60);
        $user->fpu          = 1;
        if ($user->save()) {
            try {
                Mail::to($user)->send(new AccountCreationMail($user, $password));
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
     * productFeatures
     *
     * @return void
     */
    public function productFeatures($id)
    {
        $product  = Product::find($id);
        $features = ProductFeatures::where("product_id", $id)->get();
        return view("admin.product_features", compact("product", "features"));
    }

    /**
     * storeProductFeature
     *
     * @param Request request
     *
     * @return void
     */
    public function storeProductFeature(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id'      => 'required',
            'product_feature' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $feature             = new ProductFeatures;
        $feature->product_id = $request->product_id;
        $feature->feature    = $request->product_feature;
        if ($feature->save()) {
            toast('Product Feature Added Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * updateProductFeature
     *
     * @param Request request
     *
     * @return void
     */
    public function updateProductFeature(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'feature_id'      => 'required',
            'product_feature' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $feature          = ProductFeatures::find($request->feature_id);
        $feature->feature = $request->product_feature;
        if ($feature->save()) {
            toast('Product Feature Updated Successfully.', 'success');
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
            'product'      => 'required',
            'plan'         => 'required',
            'frequency'    => 'required',
            'pricing'      => 'required|numeric',
            'active_tasks' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $plan               = new SubscriptionPlan;
        $plan->product_id   = $request->product;
        $plan->plan         = $request->plan;
        $plan->frequency    = $request->frequency;
        $plan->pricing      = $request->pricing;
        $plan->active_tasks = $request->active_tasks;
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

        $plan               = SubscriptionPlan::find($request->plan_id);
        $plan->product_id   = $request->product;
        $plan->plan         = $request->plan;
        $plan->frequency    = $request->frequency;
        $plan->pricing      = $request->pricing;
        $plan->active_tasks = $request->active_tasks;
        if ($plan->save()) {
            toast('Product Plan Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * newCustomer
     *
     * @return void
     */
    public function newCustomer()
    {
        $products = Product::all();

        return view("admin.new_customer", compact("products"));
    }

    /**
     * registeredCustomers
     *
     * @return void
     */
    public function registeredCustomers()
    {
        $status  = request()->status;
        $search  = request()->search;
        $product = request()->product;

        $query = User::query();

        $query->where("role_id", 0);

        if (isset(request()->search)) {
            $query->whereLike(["last_name", "other_names", "email", "phone_number"], $search);
        }

        if (isset(request()->product)) {
            $query->whereHas('subscription', function ($query) use ($product) {
                $query->where('product_id', $product);
            });

        }

        if (isset(request()->status)) {
            $query->where("status", $status);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $customers  = $query->paginate(50);

        $products = Product::all();

        return view("admin.registered_customers", compact('customers', 'status', 'search', 'products', 'product'));
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
            'last_name'       => 'required',
            'first_name'      => 'required',
            'email'           => 'required|unique:users',
            'phone_number'    => 'required|unique:users',
            'organization'    => 'nullable',
            'contact_address' => 'nullable',
            'product'         => 'nullable',
            'plan'            => 'nullable',
            'effective_date'  => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        try {
            $plan = SubscriptionPlan::find($request->plan);

            if ($plan->frequency == "yearly") {
                $duration = 12;
            } else if ($plan->frequency == "quarterly") {
                $duration = 3;
            } else {
                $duration = 1;
            }

            DB::beginTransaction();

            $customer                  = new User;
            $customer->last_name       = $request->last_name;
            $customer->other_names     = $request->first_name;
            $customer->email           = $request->email;
            $customer->phone_number    = $request->phone_number;
            $customer->password        = Hash::make($request->phone_number);
            $customer->role_id         = 0;
            $customer->organization    = ucwords(strtolower($request->organization));
            $customer->contact_address = $request->contact_address;
            $customer->token           = Str::random(60);
            $customer->save();

            $subscription                 = new CustomerSubscription;
            $subscription->user_id        = $customer->id;
            $subscription->product_id     = $request->product;
            $subscription->plan_id        = $request->plan;
            $subscription->pricing        = $plan->pricing;
            $subscription->effective_date = $request->effective_date;
            $subscription->expiry_date    = Carbon::now()->addMonths($duration);
            $subscription->save();

            DB::commit();

            try {
                Mail::to($customer)->send(new CustomerCreationMail($customer, $customer->phone_number));
            } catch (\Exception $e) {
                report($e);
            } finally {
                toast('Client Account Created Successfully.', 'success');
                return back();
            }
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();

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
            toast('Client Information Updated Successfully.', 'success');
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
     * changeCustomerPlan
     *
     * @param Request request
     *
     * @return void
     */
    public function changeCustomerPlan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer'       => 'required',
            'product'        => 'required',
            'plan'           => 'required',
            'effective_date' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        try {
            $plan = SubscriptionPlan::find($request->plan);

            if ($plan->frequency == "yearly") {
                $duration = 12;
            } else if ($plan->frequency == "quarterly") {
                $duration = 3;
            } else {
                $duration = 1;
            }

            DB::beginTransaction();

            $subscription = CustomerSubscription::where("user_id", $request->customer)->update([
                "status" => "terminated",
            ]);

            $subscription                 = new CustomerSubscription;
            $subscription->user_id        = $request->customer;
            $subscription->product_id     = $request->product;
            $subscription->plan_id        = $request->plan;
            $subscription->effective_date = $request->effective_date;
            $subscription->pricing        = $plan->pricing;
            $subscription->expiry_date    = Carbon::now()->addMonths($duration);
            $subscription->save();

            DB::commit();

            toast('Client Subscription Activated Successfully.', 'success');
            return back();

        } catch (\Exception $e) {
            report($e);
            DB::rollback();

            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * taskCategories
     *
     * @return void
     */
    public function taskCategories($id)
    {
        $taskcategories = TaskCategory::where("product_id", $id)->get();
        $product        = Product::find($id);
        return view("admin.task_categories", compact("taskcategories", "product"));
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
            'category'   => 'required',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $category             = new TaskCategory;
        $category->product_id = $request->product_id;
        $category->category   = $request->category;
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
     * customerProjects
     *
     * @return void
     */
    public function customerProjects($id)
    {
        $status = request()->status;
        $search = request()->search;

        $query = Project::query();

        $query->orderBy("id", 'desc')->where("product_id", $id);

        if (isset(request()->search)) {
            $query->where(function ($param) use ($search) {
                $param->whereLike(['project_title'], $search)
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->whereLike(['last_name', 'other_names'], $search);
                    });
            });
        }

        if (isset(request()->status)) {
            $query->where("status", $status);
        }

        $lastRecord       = $query->count();
        $marker           = $this->getMarkers($lastRecord, request()->page);
        $customerProjects = $query->paginate(50);
        $customers        = User::where("role_id", 0)->get();
        $product          = Product::find($id);

        return view("admin.customer_projects", compact("customerProjects", "customers", "product", "search", "status", "marker", "lastRecord"));
    }

    /**
     * storeProject
     *
     * @param Request request
     *
     * @return void
     */
    public function storeProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer'            => 'required',
            'project_title'       => 'required',
            'project_description' => 'required',
            'product_id'          => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }
        try {

            DB::beginTransaction();

            $project                      = new Project;
            $project->product_id          = $request->product_id;
            $project->user_id             = $request->customer;
            $project->project_title       = $request->project_title;
            $project->project_description = $request->project_description;
            $project->creator             = Auth::user()->id;
            $project->save();

            $activity           = new PlatformActivities;
            $activity->user_id  = Auth::user()->id;
            $activity->owner_id = $project->user_id;
            $activity->activity = 'Created a new project "' . $project->project_title . '"';
            $activity->save();

            DB::commit();

            toast('Customer Project Created Successfully. ', 'success');
            return back();
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateProject
     *
     * @param Request request
     *
     * @return void
     */
    public function updateProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id'          => 'required',
            'customer'            => 'required',
            'project_title'       => 'required',
            'project_description' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $project                      = Project::find($request->project_id);
        $project->user_id             = $request->customer;
        $project->project_title       = $request->project_title;
        $project->project_description = $request->project_description;
        $project->creator             = Auth::user()->id;
        if ($project->save()) {
            toast('Customer Project Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * closeProject
     *
     * @param mixed id
     *
     * @return void
     */
    public function closeProject($id)
    {
        try {
            DB::beginTransaction();

            $project         = Project::find($id);
            $project->status = "closed";
            $project->save();

            $activity           = new PlatformActivities;
            $activity->user_id  = Auth::user()->id;
            $activity->owner_id = $project->user_id;
            $activity->activity = 'Closed the project "' . $project->project_title . '"';
            $activity->save();

            DB::commit();

            toast('Customer Project Closed Successfully.', 'success');
            return back();
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();

            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * customerTasks
     *
     * @return void
     */
    public function customerTasks($id)
    {
        $status    = request()->status;
        $search    = request()->search;
        $recurring = request()->recurring;

        $query = CustomerTasks::query();

        $query->orderBy("id", "desc")->where("product_id", $id);

        if (isset(request()->search)) {
            $query->where(function ($param) use ($search) {
                $param->whereLike(['title'], $search)
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->whereLike(['last_name', 'other_names'], $search);
                    });
            });
        }

        if (isset(request()->status)) {
            $query->where("status", $status);
        }

        if (isset(request()->recurring)) {
            $query->where("recurring", $recurring);
        }

        if (Auth::user()->role_id > 1) {
            $query->where("assigned_to", Auth::user()->id);
        }

        $lastRecord    = $query->count();
        $marker        = $this->getMarkers($lastRecord, request()->page);
        $customerTasks = $query->paginate(50);
        $customers     = User::where("role_id", 0)->get();
        $product       = Product::find($id);

        return view("admin.customer_tasks", compact("customerTasks", "customers", "product", "search", "status", "marker", "lastRecord"));
    }

    /**
     * newCustomerTask
     *
     * @return void
     */
    public function newCustomerTask($id)
    {
        $taskCategories = TaskCategory::where("product_id", $id)->get();
        $customers      = User::where("role_id", 0)->get();
        $product        = Product::find($id);
        return view("admin.new_customer_task", compact("taskCategories", "customers", "product"));
    }

    /**
     * storeTask
     *
     * @param Request request
     *
     * @return void
     */
    public function storeTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer'       => 'required',
            'task_summary'   => 'required',
            'product_id'     => 'required',
            'explanation'    => 'required',
            'task_category'  => 'required',
            'priority'       => 'nullable',
            'website'        => 'nullable',
            'shared_access'  => 'required',
            'attached_files' => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        try {

            $priorityCharged = false;

            if (isset($request->priority)) {

                $priorityCharged = self::chargePriorityFee($request->customer);

                if ($priorityCharged === false) {
                    toast('We could not charge client card on file for priority fee.', 'error');
                    return back();
                }
            }

            DB::beginTransaction();

            $task                   = new CustomerTasks;
            $task->product_id       = $request->product_id;
            $task->user_id          = $request->customer;
            $task->title            = $request->task_summary;
            $task->task_description = $request->explanation;
            $task->task_category    = $request->task_category;
            $task->priority         = $request->priority ?? "no";
            $task->website          = $request->website;
            $task->provided_access  = $request->shared_access;
            $task->creator          = Auth::user()->id;
            if ($request->has('attached_files')) {
                $uploadedFileUrl     = Cloudinary::upload($request->file('attached_files')->getRealPath())->getSecurePath();
                $task->attached_file = $uploadedFileUrl;
            }
            $task->save();

            $activity           = new PlatformActivities;
            $activity->user_id  = Auth::user()->id;
            $activity->owner_id = $task->user_id;
            $activity->activity = 'Created a new task "' . $task->title . '"';
            $activity->save();

            DB::commit();

            try {
                //Notify Admin Who created the Tasl
                $creator = User::find($task->creator);
                Mail::to($creator)->send(new CreatorTaskConfirmation($creator, $task));

                //Notify the Client Who Owns the Task
                $owner = User::find($task->user_id);
                Mail::to($owner)->send(new OwnerTaskNotification($owner, $task));

                if ($priorityCharged === true) {
                    $user = User::find($task->user_id);
                    Mail::to($user)->send(new PriorityPaymentConfirmation($user, $task));
                }

            } catch (\Exception $e) {
                report($e);
            }

            toast('Customer Task Created Successfully.', 'success');
            return redirect()->route("admin.customerTasks", [$task->product_id]);

        } catch (\Throwable $e) {
            report($e);
            DB::rollback();
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * chargePriorityFee
     *
     * @return void
     */
    public static function chargePriorityFee($userID)
    {
        $user = User::find($userID);
        $card = CustomerCards::where("user_id", $user->id)->where("default_card", 1)->first();

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $paymentIntent = PaymentIntent::create([
            'customer'       => $user->stripe_customer_id,
            'amount'         => (39 * 100),
            'currency'       => 'gbp',
            'payment_method' => $card->authorization_code,
            'off_session'    => true,
            'confirm'        => true,
        ]);

        $pm = "Credit Card (" . ucwords($card->card_brand) . " ****-****-****-" . $card->last_four_digits . ")";

        $invoice                 = new Invoice;
        $invoice->user_id        = $user->id;
        $invoice->due_date       = now();
        $invoice->amount         = 39.00;
        $invoice->payment_method = $pm;
        $invoice->txn_id         = "TXN" . preg_replace("/pi/", "", $paymentIntent->id);
        $invoice->status         = "paid";
        $invoice->save();

        // \Log::info($paymentIntent);

        if (isset($paymentIntent->status) && $paymentIntent->status == "succeeded") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * taskDetails
     *
     * @param mixed id
     *
     * @return void
     */
    public function taskDetails($id)
    {
        $task          = CustomerTasks::find($id);
        $staffList     = User::where("role_id", ">", 1)->get();
        $activities    = TaskActivities::orderBy("id", "desc")->where("task_id", $id)->get();
        $conversations = TaskConversation::where("task_id", $id)->get();
        $product       = Product::find($task->product_id);
        return view("admin.task_details", compact("task", "staffList", "activities", "conversations", "product"));
    }

    /**
     * assignTask
     *
     * @param Request request
     *
     * @return void
     */
    public function assignTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id'     => 'required',
            'team_member' => 'required',
            'due_date'    => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        try {
            DB::beginTransaction();

            $task                = CustomerTasks::find($request->task_id);
            $task->assigned_to   = $request->team_member;
            $task->assigned_by   = Auth::user()->id;
            $task->date_assigned = now();
            $task->save();

            $platformActivity           = new PlatformActivities;
            $platformActivity->user_id  = Auth::user()->id;
            $platformActivity->owner_id = $task->user_id;
            $platformActivity->activity = 'Assigned the task "' . $task->title . '" to ' . $task->assignee->last_name . ' ' . $task->assignee->other_names;
            $platformActivity->save();

            $activity           = new TaskActivities;
            $activity->task_id  = $task->id;
            $activity->user_id  = Auth::user()->id;
            $activity->activity = "Assigned this task to " . $task->assignee->last_name . " " . $task->assignee->other_names;
            $activity->save();

            DB::commit();

            try {
                $staff    = User::find($request->team_member);
                $customer = User::find($task->user_id);
                // $dueDate  = $request->due_date;
                Mail::to($staff)->send(new TaskAssigned($staff, $task));
                Mail::to($customer)->send(new TaskInProgress($customer, $task));
            } catch (\Exception $e) {
                report($e);
            }

            toast('Task Successfully Assigned To Team Member.', 'success');
            return back();

        } catch (\Throwable $e) {
            report($e);
            DB::rollback();

            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * updateTask
     *
     * @return void
     */
    public function updateTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id'        => 'required',
            'task_priority'  => 'required',
            'task_status'    => 'required',
            'comment'        => 'nullable',
            'attached_files' => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }
        try {
            DB::beginTransaction();

            $task           = CustomerTasks::find($request->task_id);
            $task->priority = $request->task_priority;
            $task->status   = $request->task_status;
            $task->save();

            $platformActivity           = new PlatformActivities;
            $platformActivity->user_id  = Auth::user()->id;
            $platformActivity->owner_id = $task->user_id;
            $platformActivity->activity = 'Updated the status of the task "' . $task->title . '" to ' . $task->status;
            $platformActivity->save();

            if (isset($request->comment)) {
                $activity           = new TaskActivities;
                $activity->task_id  = $task->id;
                $activity->user_id  = Auth::user()->id;
                $activity->activity = "Added comment: <p>" . $request->comment . "</p>";
                $activity->save();

                $platformActivity           = new PlatformActivities;
                $platformActivity->user_id  = Auth::user()->id;
                $platformActivity->owner_id = $task->user_id;
                $platformActivity->activity = 'Commented on the task "' . $task->title . '" saying: <p>' . $request->comment . '</p>';
                $platformActivity->save();
            }

            if (isset($request->comment) || isset($request->uploaded_file)) {
                $conversation          = new TaskConversation;
                $conversation->task_id = $task->id;
                $conversation->user_id = Auth::user()->id;
                $conversation->comment = $request->comment;
                if ($request->has('attached_files')) {
                    $uploadedFileUrl             = Cloudinary::upload($request->file('attached_files')->getRealPath())->getSecurePath();
                    $conversation->uploaded_file = $uploadedFileUrl;
                }
                $conversation->save();
            }

            DB::commit();

            try {
                if ($task->status == "quality assurance") {
                    $qa    = env("QA_MAIL");
                    $staff = User::find(Auth::user()->id);
                    Mail::to($qa)->send(new InternalTaskCompletion($staff, $task));
                } else if ($task->status == "completed") {
                    $customer = User::find($task->user_id);
                    Mail::to($customer)->send(new TaskCompletion($customer, $task));
                } else {
                    $customer = User::find($task->user_id);
                    Mail::to($customer)->send(new TaskRevision($customer, $task, $request->comment));
                }
            } catch (\Exception $e) {
                report($e);
            }

            toast('Task Successfully Updated.', 'success');
            return back();
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();

            toast('Something went wrong. Please try again', 'error');
            return back();
        }

    }

    /**
     * addComment
     *
     * @return void
     */
    public function addComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id'        => 'required',
            'comment'        => 'required',
            'attached_files' => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }
        try {
            DB::beginTransaction();

            $task = CustomerTasks::find($request->task_id);

            if (isset($request->comment)) {
                $activity           = new TaskActivities;
                $activity->task_id  = $task->id;
                $activity->user_id  = Auth::user()->id;
                $activity->activity = "Added comment: <p>" . $request->comment . "</p>";
                $activity->save();

                $platformActivity           = new PlatformActivities;
                $platformActivity->user_id  = Auth::user()->id;
                $platformActivity->owner_id = $task->user_id;
                $platformActivity->activity = 'Commented on the task "' . $task->title . '" saying: <p>' . $request->comment . '</p>';
                $platformActivity->save();
            }

            if (isset($request->comment) || isset($request->uploaded_file)) {
                $conversation          = new TaskConversation;
                $conversation->task_id = $task->id;
                $conversation->user_id = Auth::user()->id;
                $conversation->comment = $request->comment;
                if ($request->has('attached_files')) {
                    $uploadedFileUrl             = Cloudinary::upload($request->file('attached_files')->getRealPath())->getSecurePath();
                    $conversation->uploaded_file = $uploadedFileUrl;
                }
                $conversation->save();
            }

            DB::commit();

            try {
                $customer = User::find($task->user_id);
                Mail::to($customer)->send(new TaskRevision($customer, $task, $request->comment));
            } catch (\Exception $e) {
                report($e);
            }

            toast('Comment Added Successfully.', 'success');
            return back();
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();

            toast('Something went wrong. Please try again', 'error');
            return back();
        }

    }

    /**
     * subscriptions
     *
     * @return void
     */
    public function subscriptions()
    {
        $status  = request()->status;
        $search  = request()->search;
        $product = request()->product;

        $query = CustomerSubscription::query();

        if (isset(request()->search)) {
            $query->whereHas('customer', function ($query) use ($search) {
                $query->whereLike(["last_name", "other_names"], $search);
            });
        }

        if (isset(request()->product)) {
            $query->where("product_id", $product);
        }

        if (isset(request()->status)) {
            $query->where("status", $status);
        }

        $lastRecord    = $query->count();
        $marker        = $this->getMarkers($lastRecord, request()->page);
        $subscriptions = $query->paginate(50);

        $products = Product::all();

        return view("admin.customer_subscriptions", compact('subscriptions', 'status', 'search', 'products', 'product'));
    }

    /**
     * customerTickets
     *
     * @return void
     */
    public function customerTickets()
    {
        $status = request()->status;
        $search = request()->search;
        $period = request()->period;

        $query = CustomerTickets::query();

        $query->orderBy("id", "desc");

        if (isset(request()->search)) {
            $query->where("subject", "like", "%{$search}%");
        }

        if (isset(request()->status)) {
            $query->where("status", $status);
        }

        if (isset(request()->period)) {
            $query->where("created_at", ">=", now()->subDays($period));
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $tickets    = $query->paginate(50);

        return view("admin.customer_tickets", compact("tickets", "status", "search", "period", "lastRecord", "marker"));
    }

    /**
     * ticketDetails
     *
     * @param mixed id
     *
     * @return void
     */
    public function ticketDetails($id)
    {
        $ticket   = CustomerTickets::find($id);
        $comments = TicketResponses::orderBy("id", "desc")->where("ticket_id", $id)->get();
        return view("admin.ticket_details", compact("ticket", "comments"));
    }

    /**
     * replyTicket
     *
     * @param Request request
     *
     * @return void
     */
    public function replyTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id'      => 'required',
            'description'    => 'required',
            'attached_files' => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        try {

            $comment            = new TicketResponses;
            $comment->user_id   = Auth::user()->id;
            $comment->role      = "staff";
            $comment->ticket_id = $request->ticket_id;
            $comment->comment   = $request->description;
            if ($request->has('attached_files')) {
                $uploadedFileUrl            = Cloudinary::upload($request->file('attached_files')->getRealPath())->getSecurePath();
                $comment->uploaded_document = $uploadedFileUrl;
            }
            $comment->save();

            toast('Reply Posted Successfully.', 'success');
            return back();

        } catch (\Throwable $e) {
            report($e);
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * closeTicket
     *
     * @param mixed id
     *
     * @return void
     */
    public function closeTicket($id)
    {
        $ticket         = CustomerTickets::find($id);
        $ticket->status = "closed";
        if ($ticket->save()) {
            toast('Customer Ticket Closed Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * customerWebsites
     *
     * @param mixed id
     *
     * @return void
     */
    public function customerWebsites($id)
    {
        $customer = User::find($id);
        $websites = OnboardingDetails::where("user_id", $id)->whereIn("operation", ["website 1", "website 2", "website 3"])->get();
        return view("admin.customer_websites", compact("websites", "customer"));
    }

    /**
     * updateWebsite
     *
     * @param Request request
     *
     * @return void
     */
    public function updateWebsite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'website_id'     => 'required',
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

        $website              = OnboardingDetails::find($request->website_id);
        $website->website_url = $request->website_url;
        $website->admin_url   = $request->admin_url;
        $website->username    = $request->admin_username;
        if ($website->save()) {
            toast('Website Information Updated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * payments
     *
     * @return void
     */
    public function payments()
    {
        $search    = request()->search;
        $product   = request()->product;
        $status    = request()->status;
        $startDate = request()->start_date;
        $endDate   = request()->end_date;

        $params = [
            'draftCount'   => Invoice::where("status", "draft")->count(),
            'draftSum'     => Invoice::where("status", "draft")->sum("amount"),
            'dueCount'     => Invoice::where("status", "due")->count(),
            'dueSum'       => Invoice::where("status", "due")->sum("amount"),
            'overdueCount' => Invoice::where("status", "overdue")->count(),
            'overdueSum'   => Invoice::where("status", "overdue")->sum("amount"),
            'invCount'     => Invoice::count(),
            'invSum'       => Invoice::sum("amount"),
        ];

        $query = Invoice::query();

        if (isset(request()->search)) {
            $query->where('invoice_number', $search)
                ->orWhereHas('customer', fn($q) => $q->whereLike(['last_name', 'other_names'], $search));
        }

        if (isset(request()->product)) {
            $query->where("product_id", $product);
        }

        if (isset(request()->status)) {
            $query->where("status", $status);
        }

        if (isset(request()->start_date)) {
            if (isset(request()->end_date)) {
                $startDate = Carbon::parse($startDate)->startOfDay();
                $endDate   = Carbon::parse($endDate)->endOfDay();
                $query->whereBetween("created_at", [$startDate, $endDate]);
            } else {
                toast('Please select end date', 'error');
                return back();
            }
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $invoices   = $query->paginate(50);

        $products  = Product::all();
        $customers = User::where("role_id", 0)->get();

        return view("admin.customer_payments", compact("invoices", "customers", "products", "lastRecord", "marker", "search", "product", "status", "startDate", "endDate", "params"));
    }

    /**
     * storeInvoice
     *
     * @param Request request
     *
     * @return void
     */
    public function storeInvoice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client'   => 'required',
            'product'  => 'required',
            'plan'     => 'required',
            'due_date' => 'required',
            'amount'   => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $invoice             = new Invoice;
        $invoice->user_id    = $request->client;
        $invoice->product_id = $request->product;
        $invoice->plan_id    = $request->plan;
        $invoice->due_date   = $request->due_date;
        $invoice->amount     = $request->amount;
        if ($invoice->save()) {
            toast('Invoice Generated Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();
        }
    }

    /**
     * downloadInvoice
     *
     * @return void
     */
    public function downloadInvoice()
    {
        $filename = "Payments_" . strtotime(now()) . ".xlsx";
        return Excel::download(new ExportInvoice(), $filename);
    }

    public function downloadInvReceipt($id)
    {
        $invoice = Invoice::find($id);
        return back();
    }

    /**
     * myFiles
     *
     * @return void
     */
    public function myFiles()
    {
        $search = request()->search;
        $client = request()->client;

        $query = CustomerFiles::query();

        $query->orderBy("id", "desc")->where("creator", Auth::user()->id);

        if (isset(request()->search)) {
            $query->where('file_name', $search);
        }

        if (isset(request()->client)) {
            $query->where(function ($q) use ($client) {
                $q->where('creator', $client)
                    ->orWhere('shared_with', $client);
            });

        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $files      = $query->paginate(50);

        $customers = User::where("role_id", 0)->get();

        return view("admin.my_files", compact("files", "search", "client", "customers", "marker", "lastRecord"));
    }

    /**
     * sharedFiles
     *
     * @return void
     */
    public function sharedFiles()
    {
        $search = request()->search;
        $client = request()->client;

        $query = CustomerFiles::query();

        $query->orderBy("id", "desc")->where("shared_with", Auth::user()->id);

        if (isset(request()->search)) {
            $query->whereLike('file_name', $search);
        }

        $lastRecord = $query->count();
        $marker     = $this->getMarkers($lastRecord, request()->page);
        $files      = $query->paginate(50);

        $customers = User::where("role_id", 0)->get();

        return view("admin.shared_files", compact("files", "search", "marker", "lastRecord", "customers", "client"));
    }

    /**
     * storeFile
     *
     * @param Request request
     *
     * @return void
     */
    public function storeFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file'      => 'required',
            'file_name' => 'required',
            'client'    => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        $file              = new CustomerFiles;
        $file->creator     = Auth::user()->id;
        $file->shared_with = $request->client;
        $file->file_name   = $request->file_name;
        $file->comment     = $request->comment;
        if ($request->has('file')) {

            $fileType = strtolower($request->file('file')->getClientOriginalExtension());

            $filename = "/files/uploaded/" . time() . "." . $request->file('file')->getClientOriginalName();
            $path     = public_path('/files/uploaded/');
            $request->file('file')->move($path, $filename);
            $file->uploaded_file = env('APP_URL') . $filename;
            $file->local_path    = $filename;
            $file->file_type     = $fileType;

        }

        if ($file->save()) {
            toast('File Uploaded Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * downloadFile
     *
     * @param mixed id
     *
     * @return void
     */
    public function downloadFile($id)
    {
        $file     = CustomerFiles::find($id);
        $filePath = public_path($file->local_path);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

    }

    /**
     * deleteFile
     *
     * @param mixed id
     *
     * @return void
     */
    public function deleteFile($id)
    {
        $file = CustomerFiles::find($id);
        if ($file->delete()) {
            toast('File Deleted Successfully.', 'success');
            return back();
        } else {
            toast('Something went wrong. Please try again', 'error');
            return back();

        }
    }

    /**
     * products
     *
     * @return void
     */
    public function products()
    {
        return Product::all();
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
