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
        // Ottieni tutti gli appartamenti
        $apartments = Apartment::all();

        // Itera su ciascun appartamento
        foreach ($apartments as $apartment) {
            // Ottieni tutte le sponsorizzazioni associate all'appartamento
            $sponsorships = $apartment->sponsorships()->get();

            // Itera su ciascuna sponsorizzazione
            foreach ($sponsorships as $sponsorship) {
                // Verifica se la sponsorizzazione è già scaduta
                if ($this->isSponsorshipExpired($sponsorship)) {
                    // Se la sponsorizzazione è scaduta, esegui l'operazione di scadenza
                    $this->calculateEndDateAndExpireSponsorship($apartment->id, $sponsorship->id);
                }
            }
        }
    }

    public function calculateEndDateAndExpireSponsorship($apartment_id, $sponsorship_id)
    {
        $apartment = Apartment::find($apartment_id);
        $sponsorship = $apartment->sponsorships()->where('id', $sponsorship_id)->first();
    
        if ($sponsorship) {
            // Calcola la data di fine aggiungendo le ore di durata alla data di creazione
            $endDate = Carbon::now()->addHours($sponsorship->hour_duration);
    
            // Se la data di fine è passata, fai scadere la sponsorship
            if (Carbon::now()->greaterThanOrEqualTo($endDate)) {
                // Rimuovi la riga dalla tabella pivot
                $apartment->sponsorships()->wherePivot('sponsorship_id', $sponsorship_id)->first()->pivot->delete();

                // Puoi anche fare altre operazioni qui, come notificare l'utente
            }
    
            // Salva l'appartamento solo dopo le modifiche
            $apartment->save();
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
            // Controlla se la data di fine è passata
            return Carbon::now()->greaterThanOrEqualTo($endDate);
        } else {
            // Tratta il caso in cui non ci sia alcuna associazione tra appartamento e sponsorizzazione
            // o la data di fine non è impostata
            return false;
        }
    }
}
