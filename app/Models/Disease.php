<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'treatment',
        'prevention', 
        'causes',
        'risk_factors',
        'severity',
        'is_emergency'
    ];

    protected $casts = [
        'is_emergency' => 'boolean'
    ];

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class, 'disease_symptom')
                    ->withPivot('weight')
                    ->withTimestamps();
    }
}