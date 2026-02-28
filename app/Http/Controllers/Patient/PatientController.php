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
     * @param Request $request
     * @return PatientResource
     */
    public function show_my_info(Request $request)
    {
        //token based searching for user and than patient
        $user = $request->user();
        return new PatientResource(Patient::findOrFail($user->user_id));

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     * @param string $id
     * @return void
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param string $id
     * @return void
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_my_account(Request $request)
    {
        $user = $request->user();
        $patient = Patient::where('user_id', $user->user_id)->first();
        $patient->delete();
        $user->tokens()->delete();
        $user->delete();

        return response()->json([
           "message"=>"Account erfolgreich gelöscht"
        ]);
    }
}
