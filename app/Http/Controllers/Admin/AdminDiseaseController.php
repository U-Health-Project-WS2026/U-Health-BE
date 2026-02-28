<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AdminDiseaseResource;
use App\Models\Disease;
use Illuminate\Http\Request;

class AdminDiseaseController extends Controller
{
    /**
     * GET /api/v1/admin/diseases?q=flu
     * List + Search (name/description/icd_code)
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = Disease::query();

        if ($q) {
            $query->where('name', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%")
                  ->orWhere('icd_code', 'like', "%{$q}%");
        }

        return AdminDiseaseResource::collection(
            $query->orderBy('name')->get()
        );
    }

    /**
     * POST /api/v1/admin/diseases
     * Create new disease
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'icd_code'    => ['required', 'string', 'max:255'],
        ]);

        $disease = Disease::create($data);

        // 201 antworten
        return AdminDiseaseResource::make($disease)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * GET /api/v1/admin/diseases/{id}
     * @param int $id
     * @return AdminDiseaseResource
     */
    public function show(int $id)
    {
        $disease = Disease::findOrFail($id);

        return AdminDiseaseResource::make($disease);
    }

    /**
     * PUT/PATCH /api/v1/admin/diseases/{id}
     * @param Request $request
     * @param int $id
     * @return AdminDiseaseResource
     */
    public function update(Request $request, int $id)
    {
        $disease = Disease::findOrFail($id);

        $data = $request->validate([
            'name'        => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string', 'max:255'],
            'icd_code'    => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        $disease->update($data);

        return AdminDiseaseResource::make($disease);
    }

    /**
     * DELETE /api/v1/admin/diseases/{id}
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $disease = Disease::findOrFail($id);
        $disease->delete();

        return response()->json(['message' => 'Disease deleted']);
    }
}
