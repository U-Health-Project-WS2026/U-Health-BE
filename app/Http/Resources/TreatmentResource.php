<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'treatment_id'=>$this->treatment_id,
            'patient_id'=>$this->patient_id,
            'diagnosis'=>$this->diagnosis,
            'type_of_treatment'=>$this->type_of_treatment,
            'date_of_treatment'=>$this->date_of_treatment
        ];
    }

}
