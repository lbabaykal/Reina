<?php

use App\Http\Controllers\Account\Settings\ChangePasswordController;
use App\Http\Controllers\Account\Settings\ChangeProfileController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Middleware\AuthThrottleMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', AuthThrottleMiddleware::class])
    ->group(function () {
        Route::post('login', LoginController::class);
        Route::post('register', RegisterController::class);
        Route::post('reset-password', ResetPasswordController::class);
        Route::post('forgot-password', ForgotPasswordController::class);
        Route::get('reset-password/{token}')->name('password.reset');
    });

Route::middleware('auth:sanctum')->group(function () {
    Route::post('update-profile', ChangeProfileController::class);
    Route::post('change-password', ChangePasswordController::class);
    Route::post('logout', LogoutController::class)->name('logout');

    Route::get('verify-email')->name('verification.notice');

    Route::post('email/verification-notification', EmailVerificationNotificationController::class)
        ->middleware('throttle:5,1')->name('verification.send');

    Route::post('hash-verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:5,1'])->name('verification.verify');
});
