<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerCards;
use App\Models\CustomerSubscription;
use App\Models\CustomerTasks;
use App\Models\CustomerTickets;
use App\Models\OnboardingDetails;
use App\Models\PlatformActivities;
use App\Models\Product;
use App\Models\Project;
use App\Models\TaskActivities;
use App\Models\TaskCategory;
use App\Models\TaskConversation;
use App\Models\TicketResponses;
use App\Models\User;
use Auth;
use Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;

class CustomerController extends Controller
{

    /**
     * dashboard
     *
     * @return void
     */
    public function dashboard()
    {
        $params = [
            "activeTasks"    => CustomerTasks::where("user_id", Auth::user()->id)->where("status", "in progress")->count(),
            "queuedTasks"    => CustomerTasks::where("user_id", Auth::user()->id)->where("status", "queued")->count(),
            "recurringTasks" => CustomerTasks::where("user_id", Auth::user()->id)->where("recurring", "yes")->count(),
            "completedTasks" => CustomerTasks::where("user_id", Auth::user()->id)->where("status", "completed")->count(),
        ];

        $tasks      = CustomerTasks::where("user_id", Auth::user()->id)->get();
        $projects   = Project::where("user_id", Auth::user()->id)->get();
        $activities = PlatformActivities::orderBy("id", "desc")->where("owner_id", Auth::user()->id)->get();
        return view("customer.dashboard", compact("params", "projects", "tasks", "activities"));
    }

    /**
     * dashboardAlt
     *
     * @return void
     */
    public function dashboardAlt()
    {
        $params = [
            "activeTasks"        => CustomerTasks::where("user_id", Auth::user()->id)->where("status", "in progress")->count(),
            "queuedTasks"        => CustomerTasks::where("user_id", Auth::user()->id)->where("status", "queued")->count(),
            "recurringTasks"     => CustomerTasks::where("user_id", Auth::user()->id)->where("recurring", "yes")->count(),
            "completedTasks"     => CustomerTasks::where("user_id", Auth::user()->id)->where("status", "completed")->count(),
            "activeSubscription" => CustomerSubscription::where("user_id", Auth::user()->id)->where("status", "active")->first(),
        ];

        $tasks      = CustomerTasks::where("user_id", Auth::user()->id)->get();
        $projects   = Project::where("user_id", Auth::user()->id)->get();
        $activities = PlatformActivities::orderBy("id", "desc")->get();
        return view("customer.dashboard_alt", compact("params", "projects", "tasks", "activities"));
    }

    /**
     * profile
     *
     * @return void
     */
    public function viewProfile()
    {
        return view("customer.profile");
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
            'last_name'       => 'required',
            'first_name'      => 'required',
            'phone_number'    => 'required',
            'profile_photo'   => 'required',
            'organization'    => 'required',
            'contact_address' => 'required',
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
        $user->other_names     = $request->first_name;
        $user->phone_number    = $request->phone_number;
        $user->organization    = $request->organization;
        $user->contact_address = $request->contact_address;
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
        return view("customer.security", compact("google2faSecret", "QRImage"));
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
     * customerProjects
     *
     * @return void
     */
    public function customerProjects()
    {
        $status = request()->status;
        $search = request()->search;

        $query = Project::query();

        $query->where("user_id", Auth::user()->id);

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

        return view("customer.my_projects", compact("customerProjects", "customers", "search", "status", "marker", "lastRecord"));
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
            'project_title'       => 'required',
            'project_description' => 'required',
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
            $project->user_id             = Auth::user()->id;
            $project->project_title       = $request->project_title;
            $project->project_description = $request->project_description;
            $project->creator             = Auth::user()->id;
            $project->save();

            $activity           = new PlatformActivities;
            $activity->user_id  = Auth::user()->id;
            $activity->owner_id = Auth::user()->id;
            $activity->activity = 'Created a new project "' . $project->project_title . '"';
            $activity->save();

            DB::commit();

            toast('Project Created Successfully. ', 'success');
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
        $project->project_title       = $request->project_title;
        $project->project_description = $request->project_description;
        $project->creator             = Auth::user()->id;
        if ($project->save()) {
            toast('Project Updated Successfully.', 'success');
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
            $activity->owner_id = Auth::user()->id;
            $activity->activity = 'Closed the project "' . $project->project_title . '"';
            $activity->save();

            DB::commit();

            toast('Project Closed Successfully. ', 'success');
            return back();
        } catch (\Throwable $e) {
            report($e);
            DB::rollback();

            toast('Something went wrong. Pleasetry again', 'error');
            return back();
        }
    }

    /**
     * customerTasks
     *
     * @return void
     */
    public function customerTasks()
    {
        $status = request()->status;
        $search = request()->search;

        $query = CustomerTasks::query();

        $query->where("user_id", Auth::user()->id);

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

        $lastRecord    = $query->count();
        $marker        = $this->getMarkers($lastRecord, request()->page);
        $customerTasks = $query->paginate(50);
        $customers     = User::where("role_id", 0)->get();

        return view("customer.my_tasks", compact("customerTasks", "customers", "search", "status", "marker", "lastRecord"));
    }

    /**
     * newCustomerTask
     *
     * @return void
     */
    public function newCustomerTask()
    {
        $taskCategories = TaskCategory::all();
        $projects       = Project::where("user_id", Auth::user()->id)->get();
        return view("customer.new_task", compact("taskCategories", "projects"));
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
            'project'          => 'nullable',
            'title'            => 'required',
            'task_description' => 'required',
            'task_category'    => 'required',
            'recurring'        => 'required',
            'recurring_date'   => 'required_if: recurring, yes',
            'timeline'         => 'required',
            'scheduled_date'   => 'required_if: timeline, scheduledfor later',
            'shared_access'    => 'required',
            'attached_files'   => 'nullable',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errors = implode("<br>", $errors);
            toast($errors, 'error');
            return back();
        }

        try {
            DB::beginTransaction();

            $task                   = new CustomerTasks;
            $task->user_id          = Auth::user()->id;
            $task->project_id       = $request->project;
            $task->title            = $request->title;
            $task->task_description = $request->task_description;
            $task->task_category    = $request->task_category;
            $task->recurring        = $request->recurring;
            $task->recurring_date   = preg_replace("/Day /", "", $request->recurring_date);
            $task->timeline         = $request->timeline;
            $task->date_scheduled   = $request->scheduled_date;
            $task->provided_access  = $request->shared_access;
            $task->creator          = Auth::user()->id;
            if ($request->has('attached_files')) {
                $uploadedFileUrl     = Cloudinary::upload($request->file('attached_files')->getRealPath())->getSecurePath();
                $task->attached_file = $uploadedFileUrl;
            }
            $task->save();

            $activity           = new PlatformActivities;
            $activity->user_id  = Auth::user()->id;
            $activity->owner_id = Auth::user()->id;
            $activity->activity = 'Created a new task "' . $task->title . '"';
            $activity->save();

            DB::commit();

            toast('Task Created Successfully.', 'success');
            return redirect()->route("customer.tasks");
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
                $activity->activity = "Added a comment: <p>" . $request->comment . "</p>";
                $activity->save();

                $platformActivity           = new PlatformActivities;
                $platformActivity->user_id  = Auth::user()->id;
                $platformActivity->owner_id = Auth::user()->id;
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
     * taskDetails
     *
     * @param mixed id
     *
     * @return void
     */
    public function taskDetails($id)
    {
        $task          = CustomerTasks::find($id);
        $staffList     = User::where("role_id", " > ", 1)->get();
        $activities    = TaskActivities::orderBy("id", "desc")->where("task_id", $id)->get();
        $conversations = TaskConversation::where("task_id", $id)->get();
        return view("customer.task_details", compact("task", "staffList", "activities", "conversations"));
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

        $query->orderBy("id", "desc")->where("user_id", Auth::user()->id);

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

        return view("customer.subscriptions", compact('subscriptions', 'status', 'search', 'products', 'product'));
    }

    /**
     * billing
     *
     * @return void
     */
    public function billing()
    {
        $plan          = CustomerSubscription::where("user_id", Auth::user()->id)->latest()->first();
        $customerCards = CustomerCards::where("user_id", Auth::user()->id)->get();
        return view("customer.billing", compact('plan', 'customerCards'));
    }

    /**
     * makeDefaultCard
     *
     * @param mixed cardId
     *
     * @return void
     */
    public function makeDefaultCard($cardId)
    {
        $regularCards              = CustomerCards::where("user_id", Auth::user()->id)->update(["default_card" => 0]);
        $defaultCard               = CustomerCards::find($cardId);
        $defaultCard->default_card = 1;
        if ($defaultCard->save()) {
            $user = User::where("id", Auth::user()->id)->update(["stripe_payment_method" => $defaultCard->authorization_code]);
        }

        toast('Operation Successful.', 'success');
        return back();
    }

    /**
     * submittedWebsites
     *
     * @return void
     */
    public function submittedWebsites()
    {
        $websites = OnboardingDetails::where("user_id", Auth::user()->id)->whereIn("operation", ["website 1", "website 2", "website 3"])->get();
        return view("customer.websites", compact("websites"));
    }

    /**
     * tickets
     *
     * @return void
     */
    public function tickets()
    {
        $status = request()->status;
        $search = request()->search;
        $period = request()->period;

        $query = CustomerTickets::query();

        $query->orderBy("id", "desc")->where("user_id", Auth::user()->id);

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

        return view("customer.tickets", compact("tickets", "status", "search", "period", "lastRecord", "marker"));
    }

    /**
     * submitTicket
     *
     * @param Request request
     *
     * @return void
     */
    public function submitTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject'        => 'required',
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
            DB::beginTransaction();

            $ticket          = new CustomerTickets;
            $ticket->user_id = Auth::user()->id;
            $ticket->subject = $request->subject;
            $ticket->save();

            $comment            = new TicketResponses;
            $comment->user_id   = Auth::user()->id;
            $comment->role      = "user";
            $comment->ticket_id = $ticket->id;
            $comment->comment   = $request->description;
            if ($request->has('attached_files')) {
                $uploadedFileUrl            = Cloudinary::upload($request->file('attached_files')->getRealPath())->getSecurePath();
                $comment->uploaded_document = $uploadedFileUrl;
            }
            $comment->save();

            DB::commit();

            toast('Ticket Submitted Successfully.', 'success');
            return back();

        } catch (\Throwable $e) {
            report($e);
            DB::rollback();

            toast('Something went wrong. Please try again', 'error');
            return back();
        }
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
        return view("customer.ticket_details", compact("ticket", "comments"));
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
            $comment->role      = "user";
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
            toast('Ticket Closed Successfully.', 'success');
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
