<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $services = ['WiFi', 'Posto Auto', 'Piscina', 'Portineria', 'Sauna', 'Vista Mare', 'Aria Condizionata', 'Idromassaggio', 'Minibar'];

        foreach ($services as $service) {
            $new_service = new Service();

            $new_service->name = $service;
            $new_service->slug = Str::slug($service);

            $new_service->save();
        }
    }
}
