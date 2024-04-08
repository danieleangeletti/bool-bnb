<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Apartment; // Assicurati di importare il modello corretto per Apartment
use Carbon\Carbon;

class ExpireSponsorships extends Command
{
    protected $signature = 'sponsorships:expire';
    protected $description = 'Expire sponsorships for all apartments';

    public function handle()
    {
        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {
            $sponsorships = $apartment->sponsorships()->get();

            foreach ($sponsorships as $sponsorship) {
                // Verifica se la sponsorizzazione è già scaduta
                if (!$this->isSponsorshipExpired($sponsorship)) {
                    $this->calculateEndDateAndExpireSponsorship($apartment->id, $sponsorship->id);
                }
            }
        }
    }

    public function calculateEndDateAndExpireSponsorship($apartment_id, $sponsorship_id) {
        $apartment = Apartment::find($apartment_id);
        $sponsorship = $apartment->sponsorships()->where('id', $sponsorship_id)->first();
    
        if ($sponsorship) {
            // Calcola la data di fine aggiungendo le ore di durata alla data di creazione
            $endDate = Carbon::now()->addHours($sponsorship->hour_duration);
    
            // Aggiorna il campo end_date nella tabella pivot
            if ($apartment->sponsorships()->wherePivot('sponsorship_id', $sponsorship_id)->exists()) {
                $apartment->sponsorships()->updateExistingPivot($sponsorship_id, ['end_date' => $endDate], [], 'apartment_sponsorship');
            }
    
            // Salva l'appartamento dopo l'aggiornamento
            $apartment->save();
            
            // Se la data di fine è passata, fai scadere la sponsorship
            if (Carbon::now()->greaterThanOrEqualTo($endDate)) {
                $apartment->sponsorships()->detach($sponsorship_id);
                // Puoi anche fare altre operazioni qui, come notificare l'utente
            }
        } else {
            // La sponsorship non è associata all'appartamento
            // Puoi gestire questo caso come preferisci, ad esempio emettere un avviso o un log
        }
    }

    public function isSponsorshipExpired($sponsorship)
{
    // Verifica se $sponsorship->apartment_sponsorship è null prima di tentare di accedere a end_date
    if ($sponsorship->apartment_sponsorship && $sponsorship->apartment_sponsorship->end_date) {
        $endDate = Carbon::parse($sponsorship->apartment_sponsorship->end_date);
        return Carbon::now()->greaterThanOrEqualTo($endDate);
    } else {
        // Tratta il caso in cui non ci sia alcuna associazione tra appartamento e sponsorizzazione
        return false;
    }
}

}
