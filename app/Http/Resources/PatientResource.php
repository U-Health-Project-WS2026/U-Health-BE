<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //all the params admin should see of patients
        return [
            'patient_id'=>$this->patient_id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'age'=>$this->age,
            'sex'=>$this->sex,
            'location'=>$this->location,
            'user_info'=>new UserResource($this->users)
        ];
    }
}
