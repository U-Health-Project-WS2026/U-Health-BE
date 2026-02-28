<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $user = $request->user();

        //his current token gets deleted
        $user->tokens()->delete();

        //IF user email is not verified
        if (! $user->hasVerifiedEmail()) {
            $key = 'verify-resend:' . $user->id;

            //ONE TIME A MINUTE USER COULD REQUEST A VERFICATION EMAIL
            if (RateLimiter::attempt($key, 1, function () use ($user) {
                $user->sendEmailVerificationNotification();
            }, 60));

            return response()->json([
                "message" => "E-MAIL NOT VERFIED. WE SENT YOU A NEW VERIFICATION E-MAIL",
                "needs_verification" => true,
            ], 403);
        }

        //IF USER IS VERIFIED
        //new token is created
        $token = $user->createToken('LOG-user_token')->plainTextToken;
        return response()->json([
            "user"=>$user,
            "token"=>$token
        ]);
    }

    public function admin_store(LoginRequest $request)
    {
        $request->authenticate();
        $user = $request->user();

        if(!$user->is_admin)
        {
            return response()->json([
                "message"=> "Nice try, You are not an admin!"
            ],403);
        }
        if (! $user->hasVerifiedEmail()) {
            $key = 'verify-resend:' . $user->id;

            //ONE TIME A MINUTE USER COULD REQUEST A VERFICATION EMAIL
            if (RateLimiter::attempt($key, 1, function () use ($user) {
                $user->sendEmailVerificationNotification();
            }, 60));

            return response()->json([
                "message" => "E-MAIL NOT VERFIED. WE SENT YOU A NEW VERIFICATION E-MAIL",
                "needs_verification" => true,
            ], 403);
        }

        $user->tokens()->delete();
        $token = $user->createToken('LOG-user_token')->plainTextToken;
        return response()->json([
            "user"=>$user,
            "token"=>$token
        ]);
    }

    /**
     * Destroy an authenticated session.
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {

        $request->user()->tokens()->delete();

        return response()->noContent();
    }
}
