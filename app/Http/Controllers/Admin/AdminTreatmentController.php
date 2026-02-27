<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Disease;
use App\Models\Treatment;
use App\Models\Medication;
class AdminTreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Treatment::all();
    }


    /**
     * Summary of find_diseases_ids
     * @param array $diseases_names
     * @return array{id: int[]}
     * Return the ids of the diseases
     */
    public function find_diseases_ids(array $diseases_names){
        $dis_ids = [];
        foreach($diseases_names as $d){

            $disease_id = Disease::where(function ($query) use ($d) {
                $query->where('icd_code', $d)
                    ->orWhere('name', 'like', "%{$d}%");
            })->value('disease_id');

            if ($disease_id) {
                $dis_ids[] = $disease_id;
            }
        }
        return $dis_ids;
    }


    /**
     * Summary of find_medication_id
     * @param string $medication_name
     * @return int id
     */
    public function find_medication_id(string $medication_name): int {
        $medication_id = Medication::where('name', 'like', "%{$medication_name}%")
            ->value('medication_id');

        return $medication_id;
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'diagnosis' => 'required|string',
            'type_of_treatment' => 'required|string',
            'date_of_treatment' => 'required|date',

            'diseases' => 'array',
            'medications' => 'array',
        ]);

        //Create a Treatment
        $treatment = Treatment::create([
            'patient_id' => $data['patient_id'],
            'diagnosis' => $data['diagnosis'],
            'type_of_treatment' => $data['type_of_treatment'],
            'date_of_treatment' => $data['date_of_treatment'],
        ]);

        $diaease_ids = $this->find_diseases_ids($data['diseases']);


        //Search for Disease ids and create pivot tables
        if (!empty($diaease_ids)) {
            $treatment->diseases()->attach($diaease_ids);
        }

        //Search for Medication ids and create pivot tables
        if (!empty($data['medications'])) {

            $medicationData = [];

            foreach ($data['medications'] as $med) {
                $medication_id = $this->find_medication_id($med['medication_name']);

                $medicationData[$medication_id] = [
                    'dosis' => $med['dosis'],
                    'amount' => $med['amount'],
                ];
            }

            $treatment->medications()->attach($medicationData);
        }

        $t = Treatment::with(['diseases','medications' // pivot kommt mit, weil du ->withPivot() im Model hast
        ])->findOrFail($treatment->treatment_id);


        return response()->json([
            "treatment"=>$t,
        ], 201);
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
    public function destroy(string $id)
    {
        //
    }
}
