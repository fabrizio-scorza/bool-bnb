<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\User;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        //

        $user_ids = User::all()->pluck('id')->all();
        $category_ids = Category::all()->pluck('id')->all();
        $service_ids = Service::all()->pluck('id')->all();
        $plan_ids = Plan::all()->pluck('id')->all();

        for ($i = 0; $i < 25; $i++) {
            $new_house = new House();

            $new_house->title = $faker->paragraph(2);
            $new_house->slug = Str::slug($new_house->title);
            $new_house->user_id = $faker->randomElement($user_ids);
            $new_house->category_id = $faker->optional(weight: 0.9)->randomElement($category_ids);
            $new_house->description = $faker->paragraph(6);
            $new_house->rooms = rand(1, 15);
            $new_house->beds = rand(1, 45);
            $new_house->bathrooms = rand(1, 4);
            $new_house->square_mt = rand(30, 1000);
            $new_house->address = $faker->address();
            $new_house->latitude = $faker->randomFloat(8, 41.7, 42.2);
            $new_house->longitude = $faker->randomFloat(8, 12.4, 12.9);
            $new_house->thumb = $faker->url();
            $new_house->available = $faker->boolean();
            $new_house->price_per_night = $faker->randomFloat(2, 25, 1500);

            $new_house->save();

            $rand_service_ids = $faker->randomElements($service_ids, null);
            $new_house->services()->attach($rand_service_ids);

            $rand_plan_id = $faker->optional()->randomElement($plan_ids);

            if ($rand_plan_id) {
                $plan = Plan::find($rand_plan_id);
                $created_at = Carbon::now();
                $expires_at = $created_at->copy()->addHours($plan->length);

                $new_house->plans()->attach(
                    $rand_plan_id,
                    [
                        'created_at' => $created_at,
                        'expires_at' => $expires_at,
                    ]
                );
            }
        }
    }
}
