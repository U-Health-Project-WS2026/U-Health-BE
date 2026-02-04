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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        //request get validated
        $data = $request->validated();

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
        $token = $user->createToken('REG-user_token')->plainTextToken;
        //event(new Registered($user));

        //Auth::login($user);

        return response()->json([
            "message"=>"USER ERFOLGREICH EINGELOOGT UND PATIENT ERSTELLT",
            "token"=>$token
        ]);
    }
}
