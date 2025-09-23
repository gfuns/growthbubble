<?php

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\StripeController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/initiateCardAddition', [StripeController::class, 'initiateCardAddition'])->name('customer.initiateCardAddition');

    Route::post('/savePaymentMethod', [StripeController::class, 'savePaymentMethod'])->name('customer.savePaymentMethod');

    Route::get('/pmSuccess', [StripeController::class, 'pmSuccess'])->name('customer.pmSuccess');

});
