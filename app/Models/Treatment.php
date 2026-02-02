<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table ='treatments';
    protected $primaryKey = 'treatment_id';
    protected $fillable = [
        'user_id',
        'diagnosis',
        'type_of_treatment',
        'date_of_treatment',
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function diseases(){
        return $this->belongsToMany(Disease::class, 'treatments_diseases', 'treatment_id', 'disease_id');
    }

    public function medications(){
        return $this->belongsToMany(Medication::class, 'treatments_medications', 'treatment_id', 'medication_id')
            ->withPivot('dosis','amount');
    }
}

