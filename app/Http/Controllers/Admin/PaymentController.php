<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Braintree\Gateway;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

// Models
use App\Models\Apartment;
use App\Models\Sponsorship;

class PaymentController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => config('env.BRAINTREE_ENV'),
            'merchantId' => config('env.BRAINTREE_MERCHANT_ID'),
            'publicKey' => config('env.BRAINTREE_PUBLIC_KEY'),
            'privateKey' => config('env.BRAINTREE_PRIVATE_KEY')
        ]);
    }

    public function checkout(Request $request)
    {   
        $apartment_id =$request->input('apartment_id');
        $apartment = Apartment::where('id', $apartment_id)->firstOrFail();

        $sponsorship_id = $request->input('sponsorship_id');
        $sponsorship = Sponsorship::where('id', $sponsorship_id)->firstOrFail();

        $clientToken = $this->gateway->clientToken()->generate();

        return view('admin.checkout', compact('clientToken', 'sponsorship', 'apartment'));
    }

    public function processPayment(Request $request)
    {   $apartment_id = $request->input('apartment_id');
        $apartment = Apartment::where('id', $apartment_id)->firstOrFail();

        $sponsorship_id = $request->input('sponsorship_id');
        $sponsorship = Sponsorship::where('id', $sponsorship_id)->firstOrFail();
        
        $nonce = $request->input('payment_method_nonce');

        $result = $this->gateway->transaction()->sale([
            'amount' => $sponsorship->cost,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        $now = Carbon::now();

        if ($result->success) {
            // Pagamento completato con successo
            if (!$apartment->sponsorships()->where('sponsorship_id', $sponsorship_id)->exists()) {
                    
                $apartment->sponsorships()->attach($sponsorship_id, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            return redirect()->back()->with('success_message', 'Pagamento completato con successo.');
        } else {
            // Gestire errori di pagamento
            $error = $result->message;
            return redirect()->back()->withErrors([$error]);
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
}
