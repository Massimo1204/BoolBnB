<?php

use App\User;
use App\Model\Apartment;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $user_ids = User::pluck('id')->toArray();
        $response = Http::get('https://api.unsplash.com/search/photos?client_id='.env("APP_KEYHOUSE").'&&query=apartment');
        $data = json_decode($response->body(), true);

        
            $count=0;
            $countImg=0;
        for($i=0; $i < 50; $i++){

            
            $newApartment = new Apartment();
            $newApartment->user_id = $faker->randomElement($user_ids);
            $newApartment->n_rooms = $faker->numberBetween(1,10);
            $newApartment->n_bedrooms = $faker->numberBetween(1,10);
            $newApartment->n_bathrooms = $faker->numberBetween(1,3);
            $newApartment->n_beds = $faker->numberBetween(1,10);
            $newApartment->guests = $faker->numberBetween(1,20);
            $newApartment->title = $faker->word();
            $newApartment->address = $faker->streetAddress();
            $newApartment->lat = $faker->latitude($min=36.647000, $max= 44.000000);
            $newApartment->long = $faker->longitude($min=7.900000, $max= 15.080000);
            $newApartment->visible = $faker->boolean();
            $newApartment->square_meters = $faker->numberBetween(30,3000);
            $newApartment->available = $faker->boolean();
            $newApartment->price = $faker->randomFloat(2,70,1000);
            if($i % 10 == 0){
                $count++;
                $countImg=0;
                $response = Http::get('https://api.unsplash.com/search/photos?client_id=x7wuqYgBvdtaD-KAanKQUq-aFQPr1b0AgWKs2FAiwWM&&query=apartment&&page=' . $count);
                $data = json_decode($response->body(), true);
            }
            if($data["results"][$countImg]["description"]== null){
                $newApartment->description =$faker->paragraph(3);;
            }
            else{
                $newApartment->description = $data["results"][$countImg]["description"];
            }
            $newApartment->image = $data["results"][$countImg]["urls"]["full"];          
            
            $countImg++;
            $newApartment->save();

        }
    }
}
