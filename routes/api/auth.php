<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

//needs 'email', 'username', 'password', 'first_name', 'last_name', 'age', 'sex', 'location' as input
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

//needs 'email', 'password' as input
Route::post('/login', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login');

//needs 'current_password', 'password' as input
Route::post('/change-current-password',[NewPasswordController::class, 'change_password'])
    ->middleware('auth:sanctum')
    ->name('password.new');

//needs 'email' as input
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

//needs 'email', 'password', 'password_confirmation', 'token' as input
Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

// Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
//     ->middleware(['signed', 'throttle:6,1'])
//     ->name('verification.verify');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//     ->middleware(['auth', 'throttle:6,1'])
//     ->name('verification.send');

//doesnt need an input
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');

//Text
