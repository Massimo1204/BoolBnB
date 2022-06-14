<?php

use Illuminate\Database\Seeder;
use App\Model\Service;
use Faker\Generator as Faker;
use App\Model\Apartment;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $Services=config('Servicess');
            foreach ($Services as  $Service) {
                $newService=new Service();
                $newService->name=$Service;
                $newService->required=$faker->boolean();
                $newService->save();
            }
        
    }
}
