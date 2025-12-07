<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@dentalcare.com'],
            [
                'name' => 'Admin DentalCare',
                'email' => 'admin@dentalcare.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'age' => 35,
                'gender' => 'male'
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@dentalcare.com');
        $this->command->info('Password: admin123');
    }
}