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
            PicturesTableSeeder::class,
            ViewsTableSeeder::class,
            MessagesTableSeeder::class,
            SponsorshipsTableSeeder::class,
            // ServicesTableSeeder::class,
            // ApartmentServiceTableSeeder::class,
            // ApartmentSponsorTableSeeder::class,
        ]);
    }
}
