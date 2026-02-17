<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminBookingResource extends JsonResource
{
   public function toArray($request)
{
    $patient = $this->patients;

    return [
        'booking_id'      => $this->booking_id,

        'patient' => $patient ? [
            'patient_id' => $patient->patient_id,
            'first_name' => $patient->first_name,
            'last_name'  => $patient->last_name,
            'name'       => trim(($patient->first_name ?? '').' '.($patient->last_name ?? '')),
            'age'        => $patient->age,
            'sex'        => $patient->sex,
            'location'   => $patient->location,
        ] : null,

        'time_slot_start' => $this->time_slot_start,
        'time_slot_end'   => $this->time_slot_end,
        'status'          => $this->status,
    ];
}

}
