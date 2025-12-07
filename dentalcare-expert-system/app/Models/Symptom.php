<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'question', 
        'type',
        'options',
        'order',
        'is_active'
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean'
    ];

    public function diseases()
    {
        return $this->belongsToMany(Disease::class, 'disease_symptom')
                    ->withPivot('weight')
                    ->withTimestamps();
    }

    // Accessor untuk options - PERBAIKI INI
    public function getOptionsAttribute($value)
    {
        if (empty($value) || $value === 'null') {
            return null;
        }

        // Jika sudah array, return langsung
        if (is_array($value)) {
            return $value;
        }
        
        // Decode JSON
        $decoded = json_decode($value, true);
        
        // Jika decode gagal, coba hilangkan double quotes
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Hilangkan double quotes yang berlebihan
            $cleaned = stripslashes($value);
            $cleaned = trim($cleaned, '"');
            $decoded = json_decode($cleaned, true);
        }
        
        return $decoded ?: null;
    }

    // Mutator untuk options
    public function setOptionsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['options'] = json_encode($value);
        } else if ($value === null || $value === 'null') {
            $this->attributes['options'] = null;
        } else {
            $this->attributes['options'] = $value;
        }
    }
}