<?php

namespace App\Http\Controllers\Patient;

use App\Http\Resources\PatientResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function show_my_info(Request $request)
    {
        //token based searching for user and than patient
        $user = $request->user();
        return new PatientResource(Patient::findOrFail($user->user_id));
        
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_my_account(Request $request)
    {
        $user = $request->user();
        $patient = Patient::where('user_id', $user->user_id)->first();
        $patient->delete();
        $user->tokens()->delete();
        $user->delete();

        return response()->json([
           "message"=>"Account erfolgreich gelsöcht" 
        ]);
    }
}
