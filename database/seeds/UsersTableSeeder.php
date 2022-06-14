<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;
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
    }
}
