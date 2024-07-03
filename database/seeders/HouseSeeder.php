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

        $data = $this->getCSVData(__DIR__ . '/houses.csv');

        foreach ($data as $index => $row) {
            if ($index !== 0) {
                $new_house = new House();

                $new_house->title = $row[0];
                $new_house->slug = Str::slug($new_house->title);

                $new_house->user_id = $faker->randomElement($user_ids);
                $new_house->category_id = $faker->optional(weight: 0.9)->randomElement($category_ids);

                $new_house->description = $row[1];
                $new_house->rooms = $row[2];
                $new_house->beds = $row[3];
                $new_house->bathrooms = $row[4];
                $new_house->square_mt = $row[5];
                $new_house->address = $row[6];
                $new_house->latitude = $row[7];
                $new_house->longitude = $row[8];
                $new_house->thumb = $row[9];
                $new_house->available = $row[10];
                $new_house->price_per_night = $row[11];

                $new_house->save();

                $rand_service_ids = $faker->randomElements($service_ids, null);
                $new_house->services()->attach($rand_service_ids);

                $rand_plan_id = $faker->optional(weight: 0.4)->randomElement($plan_ids);

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

    public function getCSVData(string $path)
    {
        $data = [];

        $file_stream = fopen($path, 'r');

        if ($file_stream === false) {
            exit('Error - cannot open the file' . $path);
        }

        while (($row = fgetcsv($file_stream)) !== false) {
            $data[] = $row;
        }

        fclose($file_stream);

        return $data;
    }
}
