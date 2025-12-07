<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'disease_name', 
        'confidence_level',
        'symptoms_checked',
        'recommendation',
        'is_emergency',
        'inference_method',
        'matched_symptoms_count',
        'disease_description',
        'treatment',
        'prevention',
        'severity'
    ];

    protected $casts = [
        'symptoms_checked' => 'array',
        'is_emergency' => 'boolean',
        'confidence_level' => 'integer',
        'matched_symptoms_count' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class, 'disease_name', 'name');
    }

    // Accessor untuk formatted date
    public function getFormattedDateAttribute()
    {
        return $this->created_at->timezone('Asia/Jakarta')->format('d M Y H:i');
    }

    // Accessor untuk confidence level color
    public function getConfidenceColorAttribute()
    {
        if ($this->confidence_level >= 70) {
            return 'high';
        } elseif ($this->confidence_level >= 50) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    // Accessor untuk emergency status text
    public function getEmergencyStatusTextAttribute()
    {
        return $this->is_emergency ? 'Darurat' : 'Tidak Darurat';
    }

    // Accessor untuk formatted symptoms
    public function getFormattedSymptomsAttribute()
    {
        if (!$this->symptoms_checked) {
            return 'Tidak ada gejala';
        }

        $symptoms = [];
        foreach ($this->symptoms_checked as $key => $value) {
            $symptomId = str_replace('q', '', $key);
            $symptom = Symptom::find($symptomId);
            if ($symptom) {
                $symptoms[] = $symptom->question . ': ' . $value;
            }
        }

        return implode(', ', $symptoms);
    }
}