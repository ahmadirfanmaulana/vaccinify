<?php

namespace Database\Seeders;

use App\Models\Regional;
use App\Models\Society;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SocietyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('id_ID');

        foreach (Regional::all() as $regional) {
            foreach (range(0, 15) as $i) {
                Society::create([
                    'id_card_number' => $faker->unique()->randomNumber(8, true),
                    'regional_id' => $regional->id,
                    'name' => $faker->firstName . ' ' . $faker->lastName,
                    'password' => $faker->randomNumber(6),
                    'born_date' => $faker->dateTime('2002-04-03', 'Asia/Jakarta'),
                    'gender' => $faker->randomElement(['male', 'female']),
                    'address' => $faker->streetAddress . ', ' . $regional->province,
                ]);
            }
        }
    }
}
