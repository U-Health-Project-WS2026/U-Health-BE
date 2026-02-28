<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminDiseaseResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'disease_id'  => $this->disease_id,
            'name'        => $this->name,
            'description' => $this->description,
            'icd_code'    => $this->icd_code,
        ];
    }
}
