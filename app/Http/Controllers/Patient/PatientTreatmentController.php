<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\TreatmentResource;
use App\Models\Treatment;
use Illuminate\Http\Request;

class PatientTreatmentController extends Controller
{

    /**
     * Patient: view entire treatment history
     * GET /api/v1/patients/treatments/history
     */
    public function viewTreatmentHistory(Request $request)
    {
        //get current user
        $user = $request->user();

        //get treatments of patient with the user_id, ordered by date_of_treatment
        $treatments = $user->patients
            ->treatments()
            ->orderBy('date_of_treatment', 'desc')
            ->get();

        return TreatmentResource::collection($treatments);
    }

    /**
     * Patient: search treatment by date
     * GET /api/v1/patients/treatments/date?date_of_treatment=yyyy-mm-dd
     */
    public function searchTreatmentDate(Request $request){

        //validate data type
        $request->validate([
            'date_of_treatment' => 'required|date'
        ]);

        //get date from the url
        $date = $request->query('date_of_treatment');

        //searches for date_of_treatment(only day), ordered by date_of_treatment
        $treatments = Treatment::whereDate('date_of_treatment', $date)
            ->orderBy('date_of_treatment', 'asc')
            ->get();

        return TreatmentResource::collection($treatments);
    }

}
