<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Service;
use Illuminate\Support\Str;

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
            'Wifi',
            'Aria Condizionata', 
            'Piscina' ,
            'Spiaggia Privata' ,
            'Parcheggio',
            'Navetta',
            'Lavanderia',
            'Fumatori',
            'Animali Consentiti'
        ];

        $serviceIcons = [
            'Wifi' => 'fa-wifi',
            'Aria Condizionata' => 'fa-wind',
            'Piscina' => 'fa-water-ladder',
            'Spiaggia Privata' => 'fa-umbrella-beach',
            'Parcheggio' => 'fa-car',
            'Navetta' => 'fa-van-shuttle',
            'Lavanderia' => 'fa-jug-detergent',
            'Fumatori' => 'fa-smoking',
            'Animali Consentiti' => 'fa-paw'
        ];
        
        foreach ($allServices as $singleService) {
            $service = Service::create([
                'type_of_service' => $singleService,
                'icon' => $serviceIcons[$singleService]
            ]);
        }
        
    }
}
