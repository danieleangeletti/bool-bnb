<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

//Models
use App\models\User;
use App\Models\Apartment;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Schema::withoutForeignKeyConstraints(function () {

            User::truncate();
        });
         for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->name = fake()->name();
            $user->last_name = fake()->lastName();
            $user->date_of_birth = fake()->dateTimeBetween($startDate = '1960-01-01', $endDate = '2005-12-12');
            $user->email = fake()->email();
            $user->password = fake()->password($minLength = 6, $maxLength = 20);
            $user->save();

            // // Ottieni un insieme di ID di appartamenti casuali
            // $randomApartmentIds = Apartment::inRandomOrder()->pluck('id')->toArray();
            
            // // Prendi un massimo di 3 appartamenti casuali
            // $selectedApartmentIds = array_slice($randomApartmentIds, 0, 3);
            // dd($selectedApartmentIds);
            // // Collega gli appartamenti selezionati all'utente
            // foreach ($selectedApartmentIds as $apartmentId) {
            //     $apartment = Apartment::find($apartmentId);
            //     $apartment->user_id = $user->id;
            //     $apartment->save();
            // }
        }
        }
    }


            
