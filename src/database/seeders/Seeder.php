<?php
namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder as BaseSeeder;
use Illuminate\Support\Facades\DB;

class SykesSeeder extends BaseSeeder
{
    public function run()
    {
        $faker = Faker::create();
        
        //Create 300 fake properties.
        for ($i = 1; $i < 300; $i++) {
            DB::table('properties')->insert([
                '_fk_location' => $faker->numberBetween(1,4),
                'property_name' => $faker->firstName(),
                'near_beach' => $faker->boolean(),
                'accepts_pets' => $faker->boolean(),
                'sleeps' => $faker->numberBetween(2,5),
                'beds' => $faker->numberBetween(1,3)
            ]);
        }
        
        //Create 1000 fake bookings.
        for ($i = 1; $i < 1000; $i++) {
            $start_date = $faker->date('2022-m-d');
            $end_date = date('Y-m-d', strtotime($start_date . ' + ' . rand(1,14) . ' days'));
            DB::table('bookings')->insert([
                '_fk_property' => $faker->numberBetween(1,302),
                'start_date' => $start_date,
                'end_date' => $faker->date('2022-m-d')
            ]);
        }
        
    }
}