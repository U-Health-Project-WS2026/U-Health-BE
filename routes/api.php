<?php
//Here are all APIs for Userside
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;

use App\Http\Controllers\UserController;



Route::get('users', [UserController::class, 'userInformation'])->middleware('auth:sanctum');



require __DIR__.'/auth.php';