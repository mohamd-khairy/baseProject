<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::prefix('v1')->group(function () {

    /****************************************** public routes******************************************************* */
    Route::group([], function () {

        Auth::routes(['verify' => true]);

        Route::post('verify-otp', [LoginController::class, 'verifyOTP']);
    });

    /***************************************** auth routes*********************************************************** */
    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

        /********************UserController******************************* */
        Route::get('user', [UserController::class, 'user']);
    });
});
