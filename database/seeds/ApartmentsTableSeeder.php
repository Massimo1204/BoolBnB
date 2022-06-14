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
        for($i=0;$i<6;$i++){
            $AppartmentQuery = Http::get('https://api.unsplash.com/search/photos?client_id=x7wuqYgBvdtaD-KAanKQUq-aFQPr1b0AgWKs2FAiwWM&&query=apartment&&page='.$i);
            $Appartments = $AppartmentQuery->getBody();
            $Appartments = json_decode($Appartments, true);
            for($c=0;$c<10;$c++){
                $link=$Appartments['results'][$c]['urls']['full'];
                $imgs[]=$link;
            }
        }
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
            $newApartment->image = $imgs[$i];
            
            $newApartment->save();

        }
    }
}
