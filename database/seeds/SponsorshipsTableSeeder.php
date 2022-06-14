<?php

use App\Model\Sponsorship;
use Illuminate\Database\Seeder;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $basic = new Sponsorship();
        $basic->name = 'basic';
        $basic->duration = 24;
        $basic->price = 2.99;
        $basic->save();

        $intermediate = new Sponsorship();
        $intermediate->name = 'intermediate';
        $intermediate->duration = 72;
        $intermediate->price = 5.99;
        $intermediate->save();

        $pro = new Sponsorship();
        $pro->name = 'pro';
        $pro->duration = 144;
        $pro->price = 9.99;
        $pro->save();
    }
}
