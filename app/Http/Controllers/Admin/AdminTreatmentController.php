<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminTreatmentController extends Controller
{
    /**
     * 1) Create a new treatment record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id'         => ['required', 'integer', 'exists:patients,patient_id'],
            'diagnosis'          => ['required', 'string'],
            'type_of_treatment'  => ['required', 'string', 'max:255'],
            'date_of_treatment'  => ['required', 'date'], // accepts YYYY-MM-DD or datetime
        ]);

        $treatment = Treatment::create($validated);

        return response()->json([
            'message' => 'Treatment record created successfully.',
            'data'    => $treatment->load(['patients', 'diseases', 'medications']),
        ], 201);
    }

    /**
     * 2) Update treatment record
     * Route model binding uses treatment_id because your model has:
     * protected $primaryKey = 'treatment_id';
     */
    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'patient_id'         => ['sometimes', 'integer', 'exists:patients,patient_id'],
            'diagnosis'          => ['sometimes', 'string'],
            'type_of_treatment'  => ['sometimes', 'string', 'max:255'],
            'date_of_treatment'  => ['sometimes', 'date'],
        ]);

        $treatment->update($validated);

        return response()->json([
            'message' => 'Treatment record updated successfully.',
            'data'    => $treatment->fresh()->load(['patients', 'diseases', 'medications']),
        ]);
    }

    /**
     * 3) Search treatment by date (date only, ignores time part)
     * Example:
     * GET /api/admin/treatments/search/by-date?date=2026-02-25
     */
    public function searchByDate(Request $request)
    {
        $validated = $request->validate([
            'date'       => ['required', 'date'],
            'patient_id' => ['nullable', 'integer', 'exists:patients,patient_id'],
        ]);

        $query = Treatment::with(['patients', 'diseases', 'medications'])
            ->whereDate('date_of_treatment', $validated['date']);

        if (!empty($validated['patient_id'])) {
            $query->where('patient_id', $validated['patient_id']);
        }

        $treatments = $query->orderByDesc('date_of_treatment')->get();

        return response()->json([
            'message' => 'Treatments fetched successfully.',
            'count'   => $treatments->count(),
            'data'    => $treatments,
        ]);
    }

    /**
     * 4) View treatment history by patient id
     * Example:
     * GET /api/admin/patients/3/treatments
     */
    public function historyByPatient($patientId)
    {
        Validator::make(
            ['patient_id' => $patientId],
            ['patient_id' => ['required', 'integer', 'exists:patients,patient_id']]
        )->validate();

        $treatments = Treatment::with(['patients', 'diseases', 'medications'])
            ->where('patient_id', $patientId)
            ->orderByDesc('date_of_treatment')
            ->paginate(10);

        return response()->json([
            'message'    => 'Treatment history fetched successfully.',
            'patient_id' => (int) $patientId,
            'data'       => $treatments,
        ]);
    }
}
