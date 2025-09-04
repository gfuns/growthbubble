<?php

use App\Http\Controllers\CoralPay\CoralpayController;
use App\Http\Controllers\SoftPay\SoftPayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'config',
], function ($router) {
    Route::get('/api-token', [SoftPayController::class, 'generateAPIToken']);
    Route::get('/getTimeStamp', [CoralpayController::class, 'getTimeStamp']);
    Route::get('/getSignature', [CoralpayController::class, 'getSignature']);
    Route::get('/prepApp', [CoralpayController::class, 'prepApplication']);
});
