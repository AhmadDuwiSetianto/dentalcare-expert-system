<?php

namespace Database\Seeders;

use App\Models\Symptom;
use Illuminate\Database\Seeder;

class SymptomSeeder extends Seeder
{
    public function run()
    {
        $symptoms = [
            [
                'code' => 'Q1',
                'question' => 'Apakah Anda mengalami nyeri gigi?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 1,
                'is_active' => true
            ],
            [
                'code' => 'Q2',
                'question' => 'Apakah nyeri bersifat spontan dan berdenyut?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 2,
                'is_active' => true
            ],
            [
                'code' => 'Q3',
                'question' => 'Apakah nyeri memburuk pada malam hari?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 3,
                'is_active' => true
            ],
            [
                'code' => 'Q4',
                'question' => 'Apakah gigi terasa tinggi saat menggigit?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 4,
                'is_active' => true
            ],
            [
                'code' => 'Q5',
                'question' => 'Apakah ada pembengkakan pada gusi atau wajah?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 5,
                'is_active' => true
            ],
            [
                'code' => 'Q6',
                'question' => 'Apakah gusi mudah berdarah?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 6,
                'is_active' => true
            ],
            [
                'code' => 'Q7',
                'question' => 'Apakah ada perubahan warna gigi?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 7,
                'is_active' => true
            ],
            [
                'code' => 'Q8',
                'question' => 'Apakah ada lubang yang terlihat pada gigi?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 8,
                'is_active' => true
            ],
            [
                'code' => 'Q9',
                'question' => 'Apakah nyeri dipicu oleh makanan/minuman dingin/manis?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 9,
                'is_active' => true
            ],
            [
                'code' => 'Q10',
                'question' => 'Berapa lama nyeri bertahan setelah rangsangan?',
                'type' => 'multiple_choice',
                'options' => [
                    'short' => 'Nyeri singkat (beberapa detik)',
                    'long' => 'Nyeri bertahan lama (beberapa menit atau lebih)'
                ],
                'order' => 10,
                'is_active' => true
            ],
            [
                'code' => 'Q11',
                'question' => 'Apakah ada bau mulut yang tidak sedap?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 11,
                'is_active' => true
            ],
            [
                'code' => 'Q12',
                'question' => 'Apakah ada luka di dalam mulut?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 12,
                'is_active' => true
            ],
            [
                'code' => 'Q13',
                'question' => 'Apakah luka berbentuk bulat/oval dengan dasar putih kekuningan dan tepi kemerahan?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 13,
                'is_active' => true
            ],
            [
                'code' => 'Q14',
                'question' => 'Apakah ada plak putih seperti susu yang dapat dikerok?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 14,
                'is_active' => true
            ],
            [
                'code' => 'Q15',
                'question' => 'Apakah gigi terasa goyang?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 15,
                'is_active' => true
            ],
            [
                'code' => 'Q16',
                'question' => 'Apakah ada resesi gusi (gusi turun)?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 16,
                'is_active' => true
            ],
            [
                'code' => 'Q17',
                'question' => 'Apakah Anda merokok?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 17,
                'is_active' => true
            ],
            [
                'code' => 'Q18',
                'question' => 'Apakah Anda memiliki kebiasaan menggertakkan gigi?',
                'type' => 'yes_no',
                'options' => null,
                'order' => 18,
                'is_active' => true
            ]
        ];

        foreach ($symptoms as $symptom) {
            Symptom::create($symptom);
        }

        $this->command->info('Berhasil menambahkan ' . count($symptoms) . ' gejala ke database.');
    }
}
