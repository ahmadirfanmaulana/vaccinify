<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VaccineTableSeeder::class);
        $this->call(SpotTableSeeder::class);
        $this->call(MedicalTableSeeder::class);
        $this->call(SocietyTableSeeder::class);
    }
}
