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
}
