<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\View;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        //
        $house_ids = House::all()->pluck('id')->all();

        for ($i = 0; $i < 30; $i++) {
            $new_message = new View();

            $new_message->house_id = $faker->randomElement($house_ids);
            $new_message->ip_address = $faker->localIpv4();

            $new_message->save();
        }
    }
}
