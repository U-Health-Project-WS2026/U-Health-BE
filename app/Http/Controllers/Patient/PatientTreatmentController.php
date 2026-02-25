<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\TreatmentResource;
use App\Models\Treatment;
use Illuminate\Http\Request;

class PatientTreatmentController extends Controller
{

    /**
     * Patient: search treatment by date
     * GET /api/v1/patients/treatments/date
     */
    public function searchTreatmentDate(Request $request){

        $request->validate([
            'date_of_treatment' => 'required|date_of_treatment'
        ]);

        $date = $request->query('date_of_treatment');

        $treatments = Treatment::whereDate('date_of_treatment', $date)
            ->orderBy('date_of_treatment', 'asc')
            ->get();

        return TreatmentResource::collection($treatments);
    }

}
