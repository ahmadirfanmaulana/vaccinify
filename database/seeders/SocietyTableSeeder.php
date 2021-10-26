<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\Medical;
use App\Models\Regional;
use App\Models\Society;
use App\Models\Spot;
use App\Models\Vaccination;
use App\Models\Vaccine;
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

        $i = 1;
        foreach (Regional::all() as $regional) {

            foreach (range(1, 15) as $j) {

                $id_card = '2021';
                if (strlen($i) == 1) {
                    $id_card .= '000' . $i;
                } elseif (strlen($i) == 2) {
                    $id_card .= '00' . $i;
                } elseif (strlen($i) == 3) {
                    $id_card .= '0' . $i;
                }

                $society = Society::create([
                    'id_card_number' => $id_card,
                    'regional_id' => $regional->id,
                    'name' => $faker->firstName . ' ' . $faker->lastName,
                    'password' => '121212',
                    'born_date' => $faker->dateTime('2002-04-03', 'Asia/Jakarta'),
                    'gender' => $faker->randomElement(['male', 'female']),
                    'address' => $faker->streetAddress . ', ' . $regional->province,
                ]);

                $spots = Spot::where('regional_id', $society->regional->id)->get()->map(function($spot) {
                    return $spot->id;
                });
                $doctors  =  Medical::where('spot_id', $faker->randomElement($spots))->where('role', 'doctor')->get()->map(function($medical) {
                    return $medical->id;
                });
                $officers =  Medical::where('spot_id', $faker->randomElement($spots))->where('role', 'officer')->get()->map(function($medical) {
                    return $medical->id;
                });
                $vaccines  =  Vaccine::get()->map(function($vaccine) {
                    return $vaccine->id;
                });;

                if ($j >= 3 && $j <= 4) {
                    $consultation = Consultation::create([
                        'society_id' => $society->id,
                        'status' => 'pending',
                        'disease_history' => null,
                        'current_symptoms' => 'flu and cough',
                        'doctor_notes' => null,
                    ]);
                } elseif ($j >= 5 && $j <= 14) {
                    $consultation = Consultation::create([
                        'society_id' => $society->id,
                        'status' => 'accepted',
                        'disease_history' => null,
                        'current_symptoms' => 'flu and cough',
                        'doctor_notes' => 'ok',
                        'doctor_id' => $faker->randomElement($doctors),
                    ]);

                    // First Vaccination
                    if ($j >= 7 && $j <= 8) {
                        $first = Vaccination::create([
                            'dose' => 1,
                            'date' => '2021-10-25',
                            'society_id' => $society->id,
                            'spot_id' => $faker->randomElement($spots),
                        ]);
                    } elseif ($j >= 9 && $j <= 14) {
                        $first = Vaccination::create([
                            'dose' => 1,
                            'date' => '2021-09-01',
                            'society_id' => $society->id,
                            'spot_id' => $faker->randomElement($spots),
                            'vaccine_id' => $faker->randomElement($vaccines),
                            'doctor_id' => $faker->randomElement($doctors),
                            'officer_id' => $faker->randomElement($officers),
                        ]);
                    }


                    // Second Vaccination
                    if ($j >= 11 && $j <= 12) {
                        $second = Vaccination::create([
                            'dose' => 2,
                            'date' => '2021-10-27',
                            'society_id' => $society->id,
                            'spot_id' => $faker->randomElement($spots),
                        ]);
                    } elseif ($j >= 13 && $j <= 14) {
                        $second = Vaccination::create([
                            'dose' => 2,
                            'date' => '2021-10-27',
                            'society_id' => $society->id,
                            'spot_id' => $faker->randomElement($spots),
                            'vaccine_id' => $faker->randomElement($vaccines),
                            'doctor_id' => $faker->randomElement($doctors),
                            'officer_id' => $faker->randomElement($officers),
                        ]);
                    }

                } elseif ($j == 15) {
                    $consultation = Consultation::create([
                        'society_id' => $society->id,
                        'status' => 'declined',
                        'disease_history' => null,
                        'current_symptoms' => 'flu and cough',
                        'doctor_notes' => null,
                    ]);
                }

                $i++;

            }

        }
    }

}
