<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Braintree\Gateway;

use Illuminate\Http\Request;

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
        $sponsorship_id = $request->input('sponsorship_id');

        $clientToken = $this->gateway->clientToken()->generate();

        return view('admin.checkout', compact('clientToken', 'sponsorship_id'));
    }

    public function processPayment(Request $request)
    {   
        
        $nonce = $request->input('payment_method_nonce');

        $result = $this->gateway->transaction()->sale([
            'amount' => '10.00',
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            // Pagamento completato con successo
            return redirect()->back()->with('success_message', 'Pagamento completato con successo.');
        } else {
            // Gestire errori di pagamento
            $error = $result->message;
            return redirect()->back()->withErrors([$error]);
        }
    }
}
