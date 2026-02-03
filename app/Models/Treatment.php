<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table ='treatments';
    protected $primaryKey = 'treatment_id';
    protected $fillable = [
        'patient_id',
        'diagnosis',
        'type_of_treatment',
        'date_of_treatment',
    ];

    public function patients(){
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function diseases(){
        return $this->belongsToMany(Disease::class, 'treatments_diseases', 'treatment_id', 'disease_id');
    }

    public function medications(){
        return $this->belongsToMany(Medication::class, 'treatments_medications', 'treatment_id', 'medication_id')
            ->withPivot('dosis','amount');
    }
}

