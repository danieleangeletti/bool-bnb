@extends('layouts.app')
<script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>
@section('page-title', 'checkout')

@section('main-content')
    <h1 class="text-center">{{ $sponsorship->title }} Sponsorship</h1>
    @if (session('success_message'))
        <div class="alert alert-success">
            {{ session('success_message') }}
        </div>
    @elseif (session('error_message')) 
        <div class="alert alert-danger">
            {{ session('error_message') }}
        </div>
    @endif
    <h2 class="text-center">Sponsorizazione per: {{ $apartment->name }} in via {{ $apartment->address }}</h2>
    <h1> COST: {{ $sponsorship->cost }}€ </h1>
    <form id="payment-form" action="processPayment" method="POST" class=" shadow ">
        @csrf
        <div id="dropin-container"></div>
        <input type="submit" class="mx-3 my-3 btn btn-primary rounded-4 "/>
        <input type="hidden" name="sponsorship_id" value="{{ $sponsorship->id }}">
        <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
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
   
    
    <style>
        h1{
            color:#EA4E59;
        }
        </style>
@endsection