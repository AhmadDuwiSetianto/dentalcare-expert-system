<?php
// database/seeders/RuleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rule;
use App\Models\Disease;

class RuleSeeder extends Seeder
{
    public function run()
    {
        $rules = [
            // Karies Superfisial
            [
                'disease' => 'Karies Superfisial',
                'conditions' => [
                    ['symptom_id' => 1, 'answer' => 'no', 'operator' => 'equals'],
                    ['symptom_id' => 2, 'answer' => 'yes', 'operator' => 'equals'],
                    ['symptom_id' => 3, 'answer' => 'no', 'operator' => 'equals'],
                    ['symptom_id' => 10, 'answer' => 'short', 'operator' => 'equals']
                ],
                'confidence' => 85,
                'order' => 1
            ],
            // Karies Dalam
            [
                'disease' => 'Karies Dalam',
                'conditions' => [
                    ['symptom_id' => 1, 'answer' => 'no', 'operator' => 'equals'],
                    ['symptom_id' => 2, 'answer' => 'yes', 'operator' => 'equals'],
                    ['symptom_id' => 3, 'answer' => 'yes', 'operator' => 'equals'],
                    ['symptom_id' => 10, 'answer' => 'medium', 'operator' => 'equals']
                ],
                'confidence' => 75,
                'order' => 2
            ],
            // Pulpitis Ireversibel
            [
                'disease' => 'Pulpitis Ireversibel',
                'conditions' => [
                    ['symptom_id' => 1, 'answer' => 'yes', 'operator' => 'equals'],
                    ['symptom_id' => 3, 'answer' => 'yes', 'operator' => 'equals'],
                    ['symptom_id' => 4, 'answer' => 'yes', 'operator' => 'equals'],
                    ['symptom_id' => 10, 'answer' => 'long', 'operator' => 'equals']
                ],
                'confidence' => 90,
                'order' => 3
            ],
            // Hipersensitivitas Dentin
            [
                'disease' => 'Hipersensitivitas Dentin',
                'conditions' => [
                    ['symptom_id' => 1, 'answer' => 'no', 'operator' => 'equals'],
                    ['symptom_id' => 2, 'answer' => 'yes', 'operator' => 'equals'],
                    ['symptom_id' => 3, 'answer' => 'no', 'operator' => 'equals'],
                    ['symptom_id' => 5, 'answer' => 'yes', 'operator' => 'equals']
                ],
                'confidence' => 80,
                'order' => 4
            ]
        ];

        foreach ($rules as $ruleData) {
            $disease = Disease::where('name', $ruleData['disease'])->first();
            
            if ($disease) {
                Rule::create([
                    'disease_id' => $disease->id,
                    'conditions' => $ruleData['conditions'],
                    'confidence' => $ruleData['confidence'],
                    'execution_order' => $ruleData['order'],
                    'is_active' => true
                ]);
            }
        }
    }
}