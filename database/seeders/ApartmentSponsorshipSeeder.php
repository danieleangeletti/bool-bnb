<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ApartmentSponsorshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apartments = Apartment::all();
        $sponsorships = Sponsorship::all()->pluck('id')->toArray();
    
        if ($apartments->isEmpty() || empty($sponsorships)) {
            return;
        }
    
        $now = Carbon::now();
    
        $apartments->each(function ($apartment) use ($sponsorships, $now) {
            shuffle($sponsorships);
            $sponsorshipsForApartment = array_slice($sponsorships, 0, rand(1, count($sponsorships)));
    
            foreach ($sponsorshipsForApartment as $sponsorshipId) {
                if (!$apartment->sponsorships()->where('sponsorship_id', $sponsorshipId)->exists()) {
                    $sponsorship = Sponsorship::find($sponsorshipId);
                    
                    // Calcola la data di scadenza aggiungendo la durata dell'ora della sponsorizzazione alla data corrente
                    $endDate = $now->copy()->addHours($sponsorship->hour_duration);
    
                    $apartment->sponsorships()->attach($sponsorshipId, [
                        'end_date' => $endDate,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
    
            $apartment->save();
        });
    }
    
    
}
