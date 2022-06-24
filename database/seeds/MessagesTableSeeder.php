<?php

use App\Model\Message;
use App\Model\Apartment;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $apartment_ids = Apartment::pluck('id')->toArray();

        for ($i = 0; $i < 1000; $i++) {
            $newMessage = new Message();
            $newMessage->apartment_id = $faker->randomElement($apartment_ids);
            $newMessage->text = $faker->sentence();
            $newMessage->full_name = $faker->firstName().' '.$faker->lastName();
            $newMessage->email = $faker->email();
            $newMessage->created_at = $faker->dateTimeBetween('-1 year', 'now');
            $newMessage->save();
        }
    }
}
