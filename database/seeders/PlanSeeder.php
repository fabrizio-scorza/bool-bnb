<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $plans = [
            [
                'name' => 'Silver',
                'price' => 2.99,
                'length' => 24
            ],
            [
                'name' => 'Gold',
                'price' => 5.99,
                'length' => 72
            ],
            [
                'name' => 'Platinum',
                'price' => 9.99,
                'length' => 144
            ]
        ];

        foreach ($plans as $plan) {
            $new_plan = new Plan();

            $new_plan->name = $plan['name'];
            $new_plan->slug = Str::slug($plan['name']);
            $new_plan->price = $plan['price'];
            $new_plan->length = $plan['length'];

            $new_plan->save();
        }
    }
}
