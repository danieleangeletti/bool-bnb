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

        foreach ($allServices as $singleService) {
            $service = Service::create([
                'type_of_service' => $singleService,
                'icon' => 'ciao'
            ]);
        };
    }
}
