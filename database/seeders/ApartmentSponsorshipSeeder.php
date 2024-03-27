<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

class ApartmentSponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        // Schema::withoutForeignKeyConstraints(function () {

        // Apartment::truncate();
        // });
        $apartments = Apartment::all();
        $sponsorships = Sponsorship::all()->pluck('id')->toArray();


        if ($apartments->isEmpty() || empty($sponsorships)) {
            return;
        }
        $apartments->each(function ($apartment) use ($sponsorships) {
            shuffle($sponsorships); 
            $sponsorshipsForApartment = array_slice($sponsorships, 0, rand(1, count($sponsorships)));
            $apartment->sponsorships()->attach($sponsorshipsForApartment);
            $apartment->end_date = fake()->date();
        });
        
    }
}
