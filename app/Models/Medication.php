<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{

    protected $table = 'medications';
    protected $primaryKey = 'medication_id';
    protected $fillable = [
        'name',
        'description',
    ];

    public function treatments(){
        return $this->belongsToMany(Treatment::class, 'treatments_medications', 'medication_id', 'treatment_id')
            ->withPivot('dosis', 'amount');
    }

}