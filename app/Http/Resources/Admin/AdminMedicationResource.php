<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminMedicationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'medication_id' => $this->medication_id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
