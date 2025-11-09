<?php

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\StripeController;
use App\Http\Controllers\OnboardingController;
use Illuminate\Support\Facades\Route;

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

Route::get('/checkout', [OnboardingController::class, 'customerCheckout'])->name("checkout");

Route::post('/customerOnboarding', [OnboardingController::class, 'customerOnboarding'])->name("customerOnboarding");

Route::group([
    'prefix'     => 'onboarding',
    'middleware' => ['webauthenticated'],

], function ($router) {

    Route::get('/', function () {
        return view('customer.onboarding.instructions');
    })->name("onboarding.instructions");

    Route::get('/lastpass', function () {
        return view('customer.onboarding.lastpass');
    })->name("onboarding.lastpass");

    Route::get('/website', [OnboardingController::class, 'websites'])->name("onboarding.websites");

    Route::post('/storeWebsite', [OnboardingController::class, 'storeWebsite'])->name("onboarding.storeWebsite");

    Route::get('/additional-websites/{id}', [OnboardingController::class, 'additionalWebsites'])->name("onboarding.additionalWebsites");

    Route::post('/storeAdditionalWebsite', [OnboardingController::class, 'storeAdditionalWebsite'])->name("onboarding.storeAdditionalWebsite");

    Route::post('/completeOnboarding', [OnboardingController::class, 'completeOnboarding'])->name("onboarding.completeOnboarding");

    Route::get('/payment', [OnboardingController::class, 'subscriptionPayment'])->name("onboarding.payment");

    Route::post('/savePaymentMethod', [OnboardingController::class, 'savePaymentMethod'])->name("onboarding.savePaymentMethod");

    Route::get('/pmSuccess', [OnboardingController::class, 'pmSuccess'])->name("onboarding.pmSuccess");
});

Route::group([
    'prefix'     => 'portal/customer',
    'middleware' => ['webauthenticated', 'g2fa'],

], function ($router) {

    Route::get('dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    Route::get('dashboard2', [CustomerController::class, 'dashboardAlt'])->name('customer.dashboardAlt');

    Route::get('/view-profile', [CustomerController::class, 'viewProfile'])->name("customer.viewProfile");

    Route::get('/billing', [CustomerController::class, 'billing'])->name("customer.billing");

    Route::get('/change-password', [CustomerController::class, 'changePassword'])->name("customer.changePassword");

    Route::post('/update-profile', [CustomerController::class, 'updateProfile'])->name("customer.updateProfile");

    Route::post('/update-password', [CustomerController::class, 'updatePassword'])->name("customer.updatePassword");

    Route::get('/security', [CustomerController::class, 'security'])->name("customer.security");

    Route::post('/select2FA', [CustomerController::class, 'select2FA'])->name("customer.select2FA");

    Route::post('/enableGA', [CustomerController::class, 'enableGA'])->name("customer.enableGA");

    Route::get('/projects', [CustomerController::class, 'customerProjects'])->name('customer.projects');

    Route::post('/storeProject', [CustomerController::class, 'storeProject'])->name('customer.storeProject');

    Route::post('/updateProject', [CustomerController::class, 'updateProject'])->name('customer.updateProject');

    Route::get('/project/close/{id}', [CustomerController::class, 'closeProject'])->name('customer.closeProject');

    Route::get('/tasks', [CustomerController::class, 'customerTasks'])->name('customer.tasks');

    Route::get('/task/create', [CustomerController::class, 'newCustomerTask'])->name('customer.newCustomerTask');

    Route::get('/task/details/{id}', [CustomerController::class, 'taskDetails'])->name('customer.taskDetails');

    Route::post('/storeTask', [CustomerController::class, 'storeTask'])->name('customer.storeTask');

    Route::post('/updateTask', [CustomerController::class, 'updateTask'])->name('customer.updateTask');

    Route::get('/subscriptions', [CustomerController::class, 'subscriptions'])->name('customer.subscriptions');

    Route::get('/card/make-default/{id}', [CustomerController::class, 'makeDefaultCard'])->name('customer.card.default');

    Route::get('/initiateCardAddition', [StripeController::class, 'initiateCardAddition'])->name('customer.initiateCardAddition');

    Route::post('/savePaymentMethod', [StripeController::class, 'savePaymentMethod'])->name('customer.savePaymentMethod');

    Route::get('/pmSuccess', [StripeController::class, 'pmSuccess'])->name('customer.pmSuccess');

    Route::get('/renew-subscription/{plan}/{card}', [StripeController::class, 'renewSubscription'])->name('customer.renewSubscription');

    Route::get('/submitted-websites', [CustomerController::class, 'submittedWebsites'])->name('customer.submittedWebsites');

    Route::get('/tickets', [CustomerController::class, 'tickets'])->name('customer.tickets');

    Route::get('/ticket/details/{id}', [CustomerController::class, 'ticketDetails'])->name('customer.ticketDetails');

    Route::post('/submitTicket', [CustomerController::class, 'submitTicket'])->name('customer.submitTicket');

    Route::post('/replyTicket', [CustomerController::class, 'replyTicket'])->name('customer.replyTicket');

    Route::get('/close-ticket/{id}', [CustomerController::class, 'closeTicket'])->name('customer.closeTicket');

    Route::get('/my-files', [CustomerController::class, 'myFiles'])->name('customer.myFiles');

    Route::post('/uploadFile', [CustomerController::class, 'uploadFile'])->name('customer.uploadFile');

    Route::get('/shared-files', [CustomerController::class, 'sharedFiles'])->name('customer.sharedFiles');

});
