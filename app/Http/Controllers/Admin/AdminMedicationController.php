<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminMedicationResource;
use App\Models\Medication;
use Illuminate\Http\Request;

class AdminMedicationController extends Controller
{
    // GET /api/v1/admin/medications?q=ibu
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = Medication::query();

        if ($q) {
            $query->where('name', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%");
        }

        return AdminMedicationResource::collection(
            $query->orderBy('name')->get()
        );
    }

    // POST /api/v1/admin/medications
    /**
     * @param Request $request
     * @return AdminMedicationResource
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $med = Medication::create($data);

        return AdminMedicationResource::make($med);
    }

    // GET /api/v1/admin/medications/{id}
    /**
     * @param int $id
     * @return AdminMedicationResource
     */
    public function show(int $id)
    {
        $med = Medication::findOrFail($id);
        return AdminMedicationResource::make($med);
    }

    // PUT/PATCH /api/v1/admin/medications/{id}
    /**
     * @param Request $request
     * @param int $id
     * @return AdminMedicationResource
     */
    public function update(Request $request, int $id)
    {
        $med = Medication::findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        $med->update($data);

        return AdminMedicationResource::make($med);
    }

    // DELETE /api/v1/admin/medications/{id}
    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $med = Medication::findOrFail($id);
        $med->delete();

        return response()->json(['message' => 'Medication deleted']);
    }
}
