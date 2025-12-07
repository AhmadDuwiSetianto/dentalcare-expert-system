<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DiseaseSeeder::class,
            SymptomSeeder::class,
            DiseaseSymptomSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
