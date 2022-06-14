<?php

use Illuminate\Database\Seeder;
use App\Model\Picture;
use App\Model\Apartment;



class PicturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartment_ids = Apartment::pluck('id')->toArray();
        $response = Http::get('https://api.unsplash.com/search/photos?client_id='.env("APP_KEYHOUSE").'&&query=interior');
        $data = json_decode($response->body(), true);
        foreach ($apartment_ids as $apartment_id) {
            for ($i=0 ; $i < rand(7,10) ; $i++ ) { 
                $newPicture = new Picture();
                $newPicture->apartment_id = $apartment_id;
                $newPicture->image = $data["results"][$i]["urls"]["full"];
                $newPicture->save();
            }
        }

    }
}
