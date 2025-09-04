<?php

use App\Http\Controllers\Admin\AdminController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/forgot-password', [App\Http\Controllers\HelperController::class, 'forgotPassword'])->name('password.forgot');

Route::post('/login/validate2fa', [TwofactorController::class, 'validate2fa'])->name('login.validate2fa');

Route::post('/login/2fa', [TwofactorController::class, 'verify2FA'])->name('login.2fa');

Route::group([
    'prefix'     => 'portal/admin',
    'middleware' => ['webauthenticated', 'g2fa'],

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
});
