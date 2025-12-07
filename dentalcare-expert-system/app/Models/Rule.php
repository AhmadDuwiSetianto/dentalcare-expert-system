<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'disease_id',
        'conditions',
        'confidence',
        'execution_order',
        'is_active'
    ];

    protected $casts = [
        'conditions' => 'array',
        'is_active' => 'boolean'
    ];

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }

    /**
     * Scope active rules
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered by execution order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('execution_order')->orderBy('id');
    }
}