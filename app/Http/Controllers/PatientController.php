<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // Liste aller Patienten (+ einfache Suche/Filter)
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Patient::query();

        // Suche nach Name (?search=...)
        if ($search = $request->query('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filter nach Standort (?location=Berlin)
        if ($location = $request->query('location')) {
            $query->where('location', 'like', '%' . $location . '%');
        }

        return response()->json($query->get());
    }

    // einzelner Patient

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $patient = Patient::find($id);

        if (! $patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient);
    }

    // neuen Patienten anlegen (POST)

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'  => 'nullable|integer',
            'name'     => 'required|string|max:255',
            'age'      => 'nullable|integer|min:0',
            'sex'      => 'nullable|integer|min:0|max:2',
            'location' => 'nullable|string|max:255',
        ]);

        $patient = Patient::create($data);

        return response()->json($patient, 201);
    }

    // Patientendaten aktualisieren (PUT/PATCH)

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if (! $patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $data = $request->validate([
            'user_id'  => 'sometimes|integer|nullable',
            'name'     => 'sometimes|string|max:255',
            'age'      => 'sometimes|integer|min:0|nullable',
            'sex'      => 'sometimes|in:male,female,divers|nullable',
            'location' => 'sometimes|string|max:255|nullable',
        ]);

        $patient->update($data);

        return response()->json($patient);
    }


}

