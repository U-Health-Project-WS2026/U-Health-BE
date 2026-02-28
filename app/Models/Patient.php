<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table ='patients';
    protected $primaryKey = 'patient_id';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'age',
        'sex',
        'location',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings(){
        return $this->hasMany(Booking::class, 'patient_id', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function treatments()
    {
        return $this->hasMany(Treatment::class, 'patient_id', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
