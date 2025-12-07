<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin DentalCare',
                'email' => 'admin@dentalcare.com',
                'password' => Hash::make('password123'),
                'age' => 35,
                'gender' => 'male',
                'is_smoker' => false,
                'has_diabetes' => false,
                'has_heart_disease' => false,
                'has_hypertension' => false,
                'medical_history' => 'Tidak ada riwayat medis khusus'
            ],
            [
                'name' => 'Pasien Contoh',
                'email' => 'pasien@example.com',
                'password' => Hash::make('password123'),
                'age' => 28,
                'gender' => 'female',
                'is_smoker' => false,
                'has_diabetes' => false,
                'has_heart_disease' => false,
                'has_hypertension' => false,
                'medical_history' => 'Riwayat gingivitis ringan'
            ]
        ];

        foreach ($users as $userData) {
            // Gunakan updateOrCreate untuk menghindari duplikasi
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Berhasil menambahkan/memperbarui user contoh ke database.');
    }
}