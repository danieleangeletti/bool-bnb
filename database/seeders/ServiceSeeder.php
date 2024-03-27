<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {

            Service::truncate();
        });
        $allServices = [
            'Wifi' => '<i class="fa-solid fa-wifi"></i>',
            'Aria Condizionata' => '<i class="fa-solid fa-wind"></i>',
            'Piscina' => '<i class="fa-solid fa-water-ladder"></i>',
            'Spiaggia Privata' => '<i class="fa-solid fa-umbrella-beach"></i>',
            'Parcheggio' => '<i class="fa-solid fa-car"></i>',
            'Navetta' => '<i class="fa-solid fa-van-shuttle"></i>',
            'Lavanderia' => ' <i class="fa-solid fa-jug-detergent"></i>',
            'Fumatori' => ' <i class="fa-solid fa-smoking"></i>',
            'Animali Consentiti' => '<i class="fa-solid fa-paw"></i>',
        ];

        foreach ($allServices as $singleService) {
            $service = Service::create([
                'type_of_service' => $singleService,
                'slug' => str()->slug($singleService),
            ]);
        };
    }
}
