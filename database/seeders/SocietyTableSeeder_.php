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

        $j = 1;
        foreach (Regional::all() as $regional) {
            foreach (range(1, 15) as $i) {

                $id_card = '2021';
                $doctor_id = null;
                if (strlen($j) == 1) {
                    $id_card .= '000' . $j;
                } else if (strlen($j) == 2) {
                    $id_card .= '00' . $j;
                } else if (strlen($j) == 3) {
                    $id_card .= '0' . $j;
                }

                $society = Society::create([
                    'id_card_number' => $id_card,
                    'regional_id' => $regional->id,
                    'name' => $faker->firstName . ' ' . $faker->lastName,
//                    'password' => $faker->randomNumber(6),
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

                if ($i >= 3 && $i <= 13) {

                    $status = 'pending';

                    if ($i >= 5) {

                        $status = 'accepted';
                        $doctor_id = $faker->randomElement($doctors);

                        // First Vaccination
                        if ($i >= 7 && $i <= 8) {
                            $first = Vaccination::create([
                                'dose' => 1,
                                'date' => '2021-09-01',
                                'society_id' => $society->id,
                                'spot_id' => $faker->randomElement($spots),
                            ]);
                        } elseif ($i >= 9) {
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
                        if ($i >= 11 && $i <= 12) {
                            $second = Vaccination::create([
                                'dose' => 2,
                                'date' => '2021-10-27',
                                'society_id' => $society->id,
                                'spot_id' => $faker->randomElement($spots),
                            ]);
                        } elseif ($i >= 13) {
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

                    } elseif ($i == 13) {
                        $status = 'declined';
                    }

                    Consultation::create([
                        'society_id' => $society->id,
                        'status' => $status,
                        'disease_history' => null,
                        'current_symptoms' => 'flu and cough' . $i,
                        'doctor_notes' => null,
                        'doctor_id' => $doctor_id,
                    ]);
                }


                $j++;
            }
        }
    }

}
