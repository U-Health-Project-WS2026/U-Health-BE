<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $table ='Treatment';
    protected $primaryKey = 'treatment_id';
    protected $fillable = [
        'admin_id',
        //'user_id',
        'patient_id',
        'disease_id',
        'diagnosis',
        'type_of_treatment',
        'date_of_treatment',
    ];

    public function patients()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function admins()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    //public function users()
    //    {
    //        return $this->belongsTo(User::class, 'user_id', 'user_id');
    //    }

    public function diseases()
    {
        return $this->belongsToMany(Disease::class, 'treatments_diseases', 'treatment_id', 'disease_id');
    }

    public function medications(){
        return $this->belongsToMany(Medication::class, 'treatments_medications', 'treatment_id', 'medication_id')
            ->withPivot('dosis','amount');
    }
}

