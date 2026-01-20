<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table ='patients';
    protected $primaryKey = 'patient_id';
    protected $fillable = [
        'name',
        'age',
        'sex',
        'username',
        'password',
        'email',
        'location',
    ];

    public function bookings(){
        return $this->hasMany(Booking::class, 'patient_id', 'patient_id');
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class, 'patient_id', 'patient_id');
    }


}
