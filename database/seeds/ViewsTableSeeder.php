<?php

use App\Model\View;
use App\Model\Apartment;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class ViewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartment_ids = Apartment::pluck('id')->toArray();

        for ($i = 0; $i < 10000; $i++) {
            $newView = new View();
            $newView->apartment_id = $faker->randomElement($apartment_ids);
            $newView->ip_address = $faker->randomFloat();
            $newView->date_time = $faker->dateTimeBetween('-1 year', 'now');
            $newView->save();
        }
    }
}
