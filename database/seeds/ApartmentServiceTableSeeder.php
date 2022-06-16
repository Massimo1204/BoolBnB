<?php

use App\Model\Service;
use App\Model\Apartment;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ApartmentServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

        $service_ids = Service::pluck('id')->toArray();

        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {
            $apartment->services()->sync($faker->randomElements($service_ids, rand(1, 5)));
        }
    }
}
