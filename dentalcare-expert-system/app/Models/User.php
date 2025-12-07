<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'gender',
        'is_smoker',
        'has_diabetes',
        'has_heart_disease',
        'has_hypertension',
        'medical_history',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_smoker' => 'boolean',
        'has_diabetes' => 'boolean',
        'has_heart_disease' => 'boolean',
        'has_hypertension' => 'boolean',
        'is_admin' => 'boolean'
    ];

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function getLatestDiagnosis()
    {
        return $this->diagnoses()->latest()->first();
    }

    public function getDiagnosisCount()
    {
        return $this->diagnoses()->count();
    }
}