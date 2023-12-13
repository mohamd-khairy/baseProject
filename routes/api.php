<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Global\ActivityController;
use App\Http\Controllers\API\Global\TrashController;
use App\Http\Controllers\API\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Auth Routes
    |--------------------------------------------------------------------------
   */
    Auth::routes(['verify' => true]);
    Route::post('verify-otp', [LoginController::class, 'verifyOTP']);

    /*
    |--------------------------------------------------------------------------
    | App Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

        /*
        |--------------------------------------------------------------------------
        | User Routes
        |--------------------------------------------------------------------------
       */
        Route::get('user', [UserController::class, 'user']);

        /*
        |--------------------------------------------------------------------------
        | Trash Routes
        |--------------------------------------------------------------------------
       */
        Route::get('trash/{type}', [TrashController::class, 'index']);
        Route::get('trash/{trash}/{type}', [TrashController::class, 'show']);
        Route::get('trash/restore/{trash}/{type}', [TrashController::class, 'restore']);
        Route::delete('trash/{trash}/{type}', [TrashController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Activity Routes
        |--------------------------------------------------------------------------
       */
        Route::get('activity', [ActivityController::class, 'index']);
        Route::get('activity/{audit}', [ActivityController::class, 'show']);
        Route::delete('activity/{id?}', [ActivityController::class, 'destroy']);
    });
});
