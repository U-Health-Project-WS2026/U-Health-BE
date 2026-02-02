<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

     protected $table ='bookings';
    protected $primaryKey = 'booking_id';
    protected $fillable = [
         'user_id',
         'time_slot_start',
         'time_slot_end',
         'status',
     ];


    public function users(){
        return $this->belongsTo(User::class, 'user_id','user_id');
    }
}
