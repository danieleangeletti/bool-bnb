<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Sponsorship;
use GuzzleHttp\Promise\Create;

class SponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {

            Sponsorship::truncate();
        });

        $sponsorshipPackages = [
            [
                'title' => 'Smart',
                'hour_duration' => 24,
                'cost' => 2.99,
                'description' => 'Pacchetto Smart con sponsorizzazione per 24 ore.',
            ],
            [
                'title' => 'Medium',
                'hour_duration' => 72,
                'cost' => 5.99,
                'description' => 'Pacchetto Medium con sponsorizzazione per 72 ore.',
            ],
            [
                'title' => 'Premium',
                'hour_duration' => 144,
                'cost' => 9.99,
                'description' => 'Pacchetto Premium con sponsorizzazione per 144 ore.',
            ],
        ];

        for ($i = 0; $i < count($sponsorshipPackages); $i++) {

            $sponsorshipModel = new Sponsorship();
             $sponsorshipModel->title = $sponsorshipPackages[$i]['title'];
             $sponsorshipModel->hour_duration = $sponsorshipPackages[$i]['hour_duration'];
             $sponsorshipModel->cost = $sponsorshipPackages[$i]['cost'];
             $sponsorshipModel->description = $sponsorshipPackages[$i]['description'];
             $sponsorshipModel->save();
        }
        
    }
}
