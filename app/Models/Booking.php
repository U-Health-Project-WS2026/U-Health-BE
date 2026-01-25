<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

     protected $table ='bookings';
    protected $primaryKey = 'booking_id';
    protected $fillable = [
         'admin_id',
        //'user_id',
         'patient_id',
         'time_slot_start',
         'time_slot_end',
         'status',
     ];

     public function admins(){
        return $this->belongsTo(Admin::class, 'admin_id','admin_id');
     }

     //public function users(){
    //        return $this->belongsTo(User::class, 'user_id','user_id');
    //     }

    public function patients(){
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }
}
