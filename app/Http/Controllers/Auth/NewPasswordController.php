<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    /**
     * Handle an incoming new password request.
     * If a user wants forgot his password
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->string('password')),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }


    public function change_password(Request $request){
        $request->validate([
            "current_password"=> ["required", "string"],
            "password" => ["required", "string", Rules\Password::defaults()]
        ]);

        $user = $request->user();

        //Check if current password is correct
        if(!Hash::check($request->input('current_password'), $user->password)){
            throw ValidationException::withMessages([
                'current_password' => ['Your current password is wrong']
            ]);
        }
        //Check if new password equals old password
        if(Hash::check($request->input("password"), $user->password)){
            throw ValidationException::withMessages([
                'current_password' => ['New Password can not be the same as the old password']
            ]);
        };

        //Else
        $user->forceFill([
            'password' => Hash::make($request->input('password')),
        ])->save();

        return response()->json(['status' => 'password-updated']);
    }
}
