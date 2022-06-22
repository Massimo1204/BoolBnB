<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $admin = new User();
        $admin->first_name = "admin";
        $admin->last_name = "admin";
        $admin->password = Hash::make('admin');
        $admin->email = "admin@admin.admin";
        $admin->birth_date = $faker->date();
        $admin->profile_picture = "https://cdn2.vectorstock.com/i/1000x1000/13/76/icon-of-user-avatar-for-web-site-or-mobile-vector-4031376.jpg";
        $admin->save();

        $userQuery = Http::get('https://api.unsplash.com/search/photos?client_id='.env("APP_KEYHOUSE").'&&query=portrait-photography');
        $userPhotos = $userQuery->getBody();
        $userPhotos = json_decode($userPhotos, true);
        for ($i=0; $i < 10 ; $i++) {
            $newUser = new User();
            $newUser->first_name = $faker->firstName();
            $newUser->last_name = $faker->lastName();
            $newUser->email = $faker->email();
            $newUser->password = Hash::make("boolbnb" . $i) ;
            $newUser->birth_date = $faker->date();
            $newUser->profile_picture = $userPhotos ['results'][$i]['urls']['full'];
            $newUser->save();
        }
    }
}
