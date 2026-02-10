<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminBookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'booking_id'      => $this->booking_id,
            'patient_id'      => $this->patient_id,
            'time_slot_start' => $this->time_slot_start,
            'time_slot_end'   => $this->time_slot_end,
            'status'          => $this->status,
        ];
    }
}
