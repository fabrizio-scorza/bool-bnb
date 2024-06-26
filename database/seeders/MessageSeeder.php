<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        //
        $house_ids = House::all()->pluck('id')->all();

        for ($i = 0; $i < 30; $i++) {
            $new_message = new Message();

            $new_message->house_id = $faker->randomElement($house_ids);
            $new_message->email = $faker->email();
            $new_message->text = $faker->paragraph(10);

            $new_message->save();
        }
    }
}
