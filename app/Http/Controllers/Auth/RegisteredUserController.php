<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RegisterRequest $request)
    {

        //request get validated
        $data = $request->validated();

        //check if email or username are in use
        if(User::where('email', $data['email'])->exists() ||
           User::where('username', $data['username'])->exists()){
            return response()->json([
                "message"=>"Email or Username is in use. Try another Email",
            ],409);
        }


        //user based credentials get extracted
        $userData = [
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ];
        $user = User::create($userData);

        //patient based credentials get extracted
        $patientData = [
            'user_id' => $user->id,
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'age'        => $data['age'],
            'sex'        => $data['sex'],
            'location'   => $data['location'],
        ];

        //a new patient related to the user created above gets created
        $user->patients()->create($patientData);

        //event triggered -> send verification email
        event(new Registered($user));

        return response()->json([
            "message"=>"SUCCESFULLY REGISTERED - EMAIL HAS TO BE VERIFIED",
            "needs_verification" => true,
        ],201);
    }
}
