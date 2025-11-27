<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\TwofactorController;
use Illuminate\Support\Facades\Route;

#001f8e
#0716AD
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
})->name("welcome");

Auth::routes(['register' => false]);

Route::get('/register', function () {
    return redirect()->away('https://growthbubbles.com');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/forgot-password', [App\Http\Controllers\HomeController::class, 'forgotPassword'])->name('password.forgot');

Route::post('/login/validate2fa', [TwofactorController::class, 'validate2fa'])->name('login.validate2fa');

Route::post('/login/2fa', [TwofactorController::class, 'verify2FA'])->name('login.2fa');

Route::get('/account/email/verify/{token}', [OnboardingController::class, 'verifyWithLink']);

Route::post('/changeDefaultPassword', [HomeController::class, 'changeDefaultPassword'])->name("changeDefaultPassword");

Route::post('/initiatePasswordReset', [OnboardingController::class, 'initiatePasswordReset'])->name("initiatePasswordReset");

Route::get('/reset/password/{token}', [OnboardingController::class, 'verifyPasswordReset'])->name("verifyPasswordReset");

Route::post('/resetPassword', [OnboardingController::class, 'resetPassword'])->name("resetPassword");

Route::group([
    'prefix'     => 'portal/admin',
    'middleware' => ['webauthenticated', 'g2fa', 'fpu'],

], function ($router) {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/view-profile', [AdminController::class, 'viewProfile'])->name("admin.viewProfile");

    Route::get('/change-password', [AdminController::class, 'changePassword'])->name("admin.changePassword");

    Route::post('/update-profile', [AdminController::class, 'updateProfile'])->name("admin.updateProfile");

    Route::post('/update-password', [AdminController::class, 'updatePassword'])->name("admin.updatePassword");

    Route::get('/security', [AdminController::class, 'security'])->name("admin.security");

    Route::post('/select2FA', [AdminController::class, 'select2FA'])->name("admin.select2FA");

    Route::post('/enableGA', [AdminController::class, 'enableGA'])->name("admin.enableGA");

    Route::get('/user-roles', [AdminController::class, 'userRoles'])->name("admin.userRoles");

    Route::post('/storeUserRole', [AdminController::class, 'storeUserRole'])->name("admin.storeUserRole");

    Route::post('/updateUserRole', [AdminController::class, 'updateUserRole'])->name("admin.updateUserRole");

    Route::get('/roles/permissions/{id}', [AdminController::class, 'managePermissions'])->name("admin.managePermissions");

    Route::get('/staff-management', [AdminController::class, 'staffManagement'])->name("admin.staffManagement");

    Route::post('/storeStaff', [AdminController::class, 'storeStaff'])->name('admin.storeStaff');

    Route::post('/updateStaff', [AdminController::class, 'updateStaff'])->name('admin.updateStaff');

    Route::get('/suspend-staff/{id}', [AdminController::class, 'suspendStaff'])->name('admin.suspendStaff');

    Route::get('/activate-staff/{id}', [AdminController::class, 'activateStaff'])->name('admin.activateStaff');

    Route::get('/platform-features', [AdminController::class, 'platformFeatures'])->name("admin.platformFeatures");

    Route::get('/grant-feature-permission/{role}/{feature}', [AdminController::class, 'grantFeaturePermission'])->name('admin.grantFeaturePermission');

    Route::get('/revoke-feature-permission/{role}/{feature}', [AdminController::class, 'revokeFeaturePermission'])->name('admin.revokeFeaturePermission');

    Route::get('/grant-create-permission/{role}/{feature}', [AdminController::class, 'grantCreatePermission'])->name('admin.grantCreatePermission');

    Route::get('/revoke-create-permission/{role}/{feature}', [AdminController::class, 'revokeCreatePermission'])->name('admin.revokeCreatePermission');

    Route::get('/grant-edit-permission/{role}/{feature}', [AdminController::class, 'grantEditPermission'])->name('admin.grantEditPermission');

    Route::get('/revoke-edit-permission/{role}/{feature}', [AdminController::class, 'revokeEditPermission'])->name('admin.revokeEditPermission');

    Route::get('/grant-delete-permission/{role}/{feature}', [AdminController::class, 'grantDeletePermission'])->name('admin.grantDeletePermission');

    Route::get('/revoke-delete-permission/{role}/{feature}', [AdminController::class, 'revokeDeletePermission'])->name('admin.revokeDeletePermission');

    Route::get('/product-management', [AdminController::class, 'productManagement'])->name('admin.productManagement');

    Route::post('/storeProduct', [AdminController::class, 'storeProduct'])->name('admin.storeProduct');

    Route::post('/updateProduct', [AdminController::class, 'updateProduct'])->name('admin.updateProduct');

    Route::get('/product-plans', [AdminController::class, 'productPlans'])->name('admin.productPlans');

    Route::post('/storeProductPlan', [AdminController::class, 'storeProductPlan'])->name('admin.storeProductPlan');

    Route::post('/updateProductPlan', [AdminController::class, 'updateProductPlan'])->name('admin.updateProductPlan');

    Route::get('/plan-features/{id}', [AdminController::class, 'planFeatures'])->name('admin.planFeatures');

    Route::post('/storePlanFeature', [AdminController::class, 'storePlanFeature'])->name('admin.storePlanFeature');

    Route::post('/updatePlanFeature', [AdminController::class, 'updatePlanFeature'])->name('admin.updatePlanFeature');

    Route::get('/registered-customers', [AdminController::class, 'registeredCustomers'])->name('admin.customers');

    Route::get('/new-customer', [AdminController::class, 'newCustomer'])->name('admin.newCustomer');

    Route::get('/customer-websites/{id}', [AdminController::class, 'customerWebsites'])->name('admin.customerWebsites');

    Route::post('/updateWebsite', [AdminController::class, 'updateWebsite'])->name('admin.updateWebsite');

    Route::post('/storeCustomer', [AdminController::class, 'storeCustomer'])->name('admin.storeCustomer');

    Route::post('/updateCustomer', [AdminController::class, 'updateCustomer'])->name('admin.updateCustomer');

    Route::post('/changeCustomerPlan', [AdminController::class, 'changeCustomerPlan'])->name('admin.changeCustomerPlan');

    Route::get('/suspend-customer/{id}', [AdminController::class, 'suspendCustomer'])->name('admin.suspendCustomer');

    Route::get('/activate-customer/{id}', [AdminController::class, 'activateCustomer'])->name('admin.activateCustomer');

    Route::get('/task-categories/{id}', [AdminController::class, 'taskCategories'])->name('admin.taskCategories');

    Route::post('/storeTaskCategory', [AdminController::class, 'storeTaskCategory'])->name('admin.storeTaskCategory');

    Route::post('/updateTaskCategory', [AdminController::class, 'updateTaskCategory'])->name('admin.updateTaskCategory');

    Route::get('/projects/{id}', [AdminController::class, 'customerProjects'])->name('admin.customerProjects');

    Route::post('/storeProject', [AdminController::class, 'storeProject'])->name('admin.storeProject');

    Route::post('/updateProject', [AdminController::class, 'updateProject'])->name('admin.updateProject');

    Route::get('/project/close/{id}', [AdminController::class, 'closeProject'])->name('admin.closeProject');

    Route::get('/tasks/{id}', [AdminController::class, 'customerTasks'])->name('admin.customerTasks');

    Route::get('/task/create/{id}', [AdminController::class, 'newCustomerTask'])->name('admin.newCustomerTask');

    Route::get('/task/details/{id}', [AdminController::class, 'taskDetails'])->name('admin.taskDetails');

    Route::post('/storeTask', [AdminController::class, 'storeTask'])->name('admin.storeTask');

    Route::post('/assignTask', [AdminController::class, 'assignTask'])->name('admin.assignTask');

    Route::post('/updateTask', [AdminController::class, 'updateTask'])->name('admin.updateTask');

    Route::post('/addComment', [AdminController::class, 'addComment'])->name('admin.addComment');

    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');

    Route::get('/payments', [AdminController::class, 'payments'])->name('admin.payments');

    Route::post('/storeInvoice', [AdminController::class, 'storeInvoice'])->name('admin.storeInvoice');

    Route::get('/downloadInvoice', [AdminController::class, 'downloadInvoice'])->name('admin.downloadInvoice');

    Route::get('/downloadInvReceipt/{id}', [AdminController::class, 'downloadInvReceipt'])->name('admin.downloadInvReceipt');

    Route::get('/tickets', [AdminController::class, 'customerTickets'])->name('admin.customerTickets');

    Route::get('/ticket/details/{id}', [AdminController::class, 'ticketDetails'])->name('admin.ticketDetails');

    Route::post('/replyTicket', [AdminController::class, 'replyTicket'])->name('admin.replyTicket');

    Route::get('/close-ticket/{id}', [AdminController::class, 'closeTicket'])->name('admin.closeTicket');

    Route::get('/export-payments', [AdminController::class, 'downloadInvoice'])->name('admin.downloadInvoice');

    Route::get('/my-files', [AdminController::class, 'myFiles'])->name('admin.myFiles');

    Route::get('/shared-files', [AdminController::class, 'sharedFiles'])->name('admin.sharedFiles');

    Route::post('/storeFile', [AdminController::class, 'storeFile'])->name('admin.storeFile');

    Route::get('/downloadFile/{id}', [AdminController::class, 'downloadFile'])->name('admin.downloadFile');

    Route::get('/deleteFile/{id}', [AdminController::class, 'deleteFile'])->name('admin.deleteFile');
});

Route::get('/ajax/get-projects/{customer}', [AjaxController::class, 'getCustomerProjects'])->name('ajax.getCustomerProjects');

Route::get('/ajax/get-websites/{customer}', [AjaxController::class, 'getCustomerWebsites'])->name('ajax.getCustomerWebsites');

Route::get('/ajax/get-plans/{product}', [AjaxController::class, 'getProductPlans'])->name('ajax.getProductPlans');

Route::get('/ajax/fetch-plans/{product}', [AjaxController::class, 'fetchProductPlans'])->name('ajax.fetchProductPlans');

Route::group([
    'prefix' => 'cron',
], function ($router) {
    Route::get('/renew-subscription', [CronController::class, 'renewSubscription'])->name('cron.renewSubscription');
    Route::get('/expiring-subscription', [CronController::class, 'expiringSubscription'])->name('cron.expiringSubscription');
    Route::get('/inactive-clients', [CronController::class, 'inactiveClients'])->name('cron.inactiveClients');

});

require __DIR__ . '/customer.php';
