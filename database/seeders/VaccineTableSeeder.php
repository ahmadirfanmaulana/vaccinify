<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Seeder;

class VaccineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $vaccines = ['Sinovac', 'AstraZeneca', 'Moderna', 'Pfizer', 'Sinnopharm'];
        foreach ($vaccines as $vaccine) {
            Vaccine::create([
                'name' => $vaccine,
            ]);
        }
    }
}
