<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\PatientResource;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PatientResource::collection(Patient::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);
        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePatient(Request $request, string $patient_id)
    {
        //get data from database if exists
        $slot = Patient::findOrFail($patient_id);

        //validate the data
        $validated = $request->validate([
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'age' => ['sometimes', 'required', 'integer'],
            'sex' => ['sometimes', 'required', 'integer'],
            'location' => ['sometimes', 'required', 'string', 'max:255']
        ]);

        //update timeslot
        $slot->update($validated);

        //if update was successful, send message
        return response()->json([
            'message' => 'patient information updated',
            'slot'    => $slot
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete by PATIENT ID
        $user_id = Patient::findOrFail($id)->users->user_id;
        $user = User::findOrFail($user_id);
        $token = $user->currentAccessToken();

        $user->tokens()->delete();
        $user->patients()->delete();
        $user->delete();
        return response()->json([
            "message"=>"Patient erfolgreich gelöscht",
        ]);
    }
}
