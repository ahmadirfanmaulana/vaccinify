<?php

namespace Database\Seeders;

use App\Models\Regional;
use App\Models\Spot;
use App\Models\SpotVaccine;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SpotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $regionals = [
            'DKI Jakarta'  => ['Central Jakarta', 'South Jakarta'],
            'West Java'    => ['Bandung'],
        ];

        foreach ($regionals as $province => $districts) {
            foreach ($districts as $district) {
                $regional = Regional::create([
                    'province' => $province,
                    'district' => $district,
                ]);

                $this->createSpot($regional);
            }
        }


    }

    private function createSpot($regional) {
        $faker = Faker::create('id_ID');

        foreach (range(1, 5) as $i) {
            $spot = Spot::create([
                'regional_id' => $regional->id,
                'name' => $faker->lastName . ' Hospital',
                'address' => $faker->streetAddress . ', ' . $regional->province,
                'serve' => $faker->randomElement([1, 2, 3]),
                'capacity' => 15,
            ]);

            $random1 = [1,2,3,4,5];
            $random1 = [1,2,3,4];
            $random2 = [1,3,4];
            $random3 = [1,2,5];
            $random4 = [1,3,5];
            $random5 = [2,4,5];

            foreach ($faker->randomElement([$random1, $random2, $random3, $random4, $random5]) as $vaccine) {
                SpotVaccine::create([
                    'spot_id' => $spot->id,
                    'vaccine_id' => $vaccine,
                ]);
            }
        }
    }
}
