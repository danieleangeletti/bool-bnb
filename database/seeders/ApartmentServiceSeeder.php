<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;
class ApartmentServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    
    {    Schema::withoutForeignKeyConstraints(function () {

        Apartment::truncate();
    });
        $apartments = Apartment::all();
        $services = Service::all()->pluck('id')->toArray();


        if ($apartments->isEmpty() || empty($services)) {
            return;
        }
        $apartments->each(function ($apartment) use ($services) {
            shuffle($services); 
            $servicesForApartment = array_slice($services, 0, rand(1, count($services)));
            $apartment->services()->attach($servicesForApartment); 
        });
    

    }
}
