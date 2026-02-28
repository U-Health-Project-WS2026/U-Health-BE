<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

     protected $table ='bookings';
    protected $primaryKey = 'booking_id';
    protected $fillable = [
         'patient_id',
         'time_slot_start',
         'time_slot_end',
         'status',
        // 0=available
        // 1=booked
     ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patients(){
        return $this->belongsTo(Patient::class, 'patient_id','patient_id');
    }
}
