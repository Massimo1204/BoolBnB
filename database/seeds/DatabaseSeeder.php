<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ApartmentsTableSeeder::class,
            // PicturesTableSeeder::class,
            // MessagesTableSeeder::class,
            // ViewsTableSeeder::class,
            // ServicesTableSeeder::class,
            // SponsorshipsTableSeeder::class,
            // ApartmentServiceTableSeeder::class,
            // ApartmentSponsorTableSeeder::class,
        ]);
    }
}
