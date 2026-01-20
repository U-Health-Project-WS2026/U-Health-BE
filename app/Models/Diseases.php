<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diseases extends Model
{
    protected $table = 'diseases';
    protected $primaryKey = 'disease_id';
    protected $fillable = [
        'name',
        'description',
        'icd_code'
    ];

    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'treatments_diseases','disease_id', 'treatment_id');
    }
}
