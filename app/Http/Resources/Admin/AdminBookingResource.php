<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\PatientResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminBookingResource extends JsonResource
{
   public function toArray($request)
{
    $patient = $this->patients;

    return [
        'booking_id'      => $this->booking_id,

        'patient' => PatientResource::make($this->patients),

        'time_slot_start' => $this->time_slot_start,
        'time_slot_end'   => $this->time_slot_end,
        'status'          => $this->status,
    ];
}

}
