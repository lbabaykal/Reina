<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

//TODO Переделать весь этот мусор

//  Guest
Route::middleware('guest')
    ->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::post('forgot-password', ForgotPasswordController::class)->name('password.email');
    Route::post('reset-password', ResetPasswordController::class)->name('password.store');

    //Нужен для формирования роута для отправки сообщения на почту
    Route::get('reset-password/{token}')->name('password.reset');
});

//  Auth
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', LogoutController::class)->name('logout');

    //Нужен для редиректа middleware
    Route::get('verify-email')->name('verification.notice');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:3,1')->name('verification.send');

    Route::get('hash-verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:3,1'])->name('verification.verify');
});
