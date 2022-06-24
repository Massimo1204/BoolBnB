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
        $admin->profile_picture = "https://media.istockphoto.com/vectors/user-icon-admin-profile-pictogram-vector-id1327656409?b=1&k=20&m=1327656409&s=170667a&w=0&h=a8rGhCe2dgUHDa_sw38uR9v_qvyTteXrWP22BOKRViI=";
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
