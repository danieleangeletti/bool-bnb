@extends('layouts.app')
<script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>
@section('page-title', 'checkout')

@section('main-content')
    THIS IS THE CHECKOUT PAGE
    {{ $sponsorship_id }}
    <form id="payment-form" action="processPayment" method="POST">
        <div id="dropin-container"></div>
        <input type="submit" />
        <input type="hidden" id="nonce" name="payment_method_nonce" />
    </form>
    <script type="text/javascript">
        const form = document.getElementById('payment-form');
        const clientToken = "{{ $clientToken }}"
        braintree.dropin.create({
            authorization: clientToken,
            container: document.getElementById('dropin-container'),
            // ...plus remaining configuration
        }, (error, dropinInstance) => {
        if (error) console.error(error);
        form.addEventListener('submit', event => {
        event.preventDefault();
        dropinInstance.requestPaymentMethod((error, payload) => {
        if (error) console.error(error);

        // Step four: when the user is ready to complete their
        //   transaction, use the dropinInstance to get a payment
        //   method nonce for the user's selected payment method, then add
        //   it a the hidden field before submitting the complete form to
        //   a server-side integration
        document.getElementById('nonce').value = payload.nonce;
        form.submit();
                });
            });
        });
        
    </script>
@endsection