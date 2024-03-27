<?php

namespace Database\Seeders;


// tom-tom



use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Controller\Admin\ApartmentController;
use Illuminate\Support\Str;
use App\Models\Apartment;
use Illuminate\Support\Facades\Schema;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        Schema::withoutForeignKeyConstraints(function () {

            Apartment::truncate();
        });
        $apartmentName = config('db.allNameApartments');
        $apartmentAccomodation = config('db.allTypeOfAccomodation');
        $apartmentAddress =config('db.addressesWithCoordinates');
        

        for ($i = 0; $i < count( $apartmentName); $i++) {

            $apartment = new Apartment();
            $apartment->name =  $apartmentName[$i];
            $apartment->type_of_accomodation = $apartmentAccomodation[Rand(0, 9)];
            $apartment->n_guests = fake()->numberBetween(1,10);
            $apartment->n_rooms = fake()->numberBetween(1,6);
            $apartment->n_beds = fake()->numberBetween(1,9);
            $apartment->n_baths = fake()->numberBetween(1,3);
            $apartment->price = fake()->randomFloat(2 ,1 , 1000);
            $apartment->latitude =  $apartmentAddress[$i]['latitude'];
            $apartment->longitude=  $apartmentAddress[$i]['longitude'];
            $apartment->slug = Str::slug($apartmentName[$i]);
            $apartment->address =  $apartmentAddress[$i]['address'];
            $apartment->img_cover_path = fake()->imageUrl(640, 480, 'houses', true);
            $apartment->save();
        }
    }
}
