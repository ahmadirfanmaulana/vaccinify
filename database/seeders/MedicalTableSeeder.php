<?php

namespace Database\Seeders;

use App\Models\Medical;
use App\Models\Spot;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MedicalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        //
        foreach (Spot::all() as $j => $spot) {
            foreach (range(1, 3) as $i) {
                $user = User::create([
                    'username' => 'doctor' . (($i + 1) + ($j*3)),
                    'password' => bcrypt('medical'),
                ]);
                Medical::create([
                    'spot_id' => $spot->id,
                    'name' => 'Dr. ' . $faker->firstName . ' ' . $faker->lastName,
                    'role' => 'doctor',
                    'user_id' => $user->id,
                ]);
            }
            foreach (range(1, 2) as $i) {
                $user = User::create([
                    'username' => 'officer' . (($i + 1) + ($j*3)),
                    'password' => bcrypt('medical'),
                ]);
                Medical::create([
                    'spot_id' => $spot->id,
                    'name' => $faker->firstName . ' ' . $faker->lastName,
                    'role' => 'officer',
                    'user_id' => $user->id,
                ]);
            }
        }

    }
}
