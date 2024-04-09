<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSponsorshipRequest;
use App\Http\Requests\UpdateSponsorshipRequest;
use App\Models\Sponsorship;
use App\Models\Apartment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;


class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida i dati della richiesta
        $request->validate([
            // Specifica le regole di validazione per i campi della sponsorizzazione
        ]);
    
        // Crea una nuova sponsorizzazione
        $sponsorship = Sponsorship::create([
            // Imposta i campi della sponsorizzazione utilizzando i dati dalla richiesta
        ]);
    
        // Recupera gli appartamenti selezionati dalla richiesta
        $apartmentIds = $request->input('apartment_ids');
    
        // Se ci sono appartamenti selezionati
        if ($apartmentIds && is_array($apartmentIds)) {
            // Itera su ciascun appartamento selezionato
            foreach ($apartmentIds as $apartmentId) {
                // Recupera l'appartamento
                $apartment = Apartment::findOrFail($apartmentId);
                
                // Calcola la data di scadenza aggiungendo la durata dell'ora della sponsorizzazione alla data corrente
                $endDate = now()->addHours($sponsorship->hour_duration);
    
                // Associa la sponsorizzazione all'appartamento e imposta la data di scadenza
                $apartment->sponsorships()->attach($sponsorship->id, [
                    'end_date' => $endDate,
                    // Altri eventuali dati aggiuntivi da associare alla relazione
                ]);
            }
        }
    
        // Restituisci una risposta di successo o reindirizza l'utente a una pagina di conferma
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSponsorshipRequest $request, Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsorship $sponsorship)
    {
        //
    }
   
}
