@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('main-content')

    <div class="row h-50">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center text-danger">
                    Ciao {{ auth()->user()->name }}!
                </h1>
                <br>
                <div class=" d-flex justify-content-center">
                    <h4>
                        Bentornato nella tua area privata di BoolBnb
                    </h4>
                </div>
               
            </div>
        </div>
        <div class=" d-flex  justify-content-center h-50 ">
            <img src="{{ asset('img/Immagine_WhatsApp_2024-04-03_ore_14.06.30_25a33b0a.jpg') }}" class=" w-50 h-100 " alt="">
        </div>
       
    </div>
    <div class="row">
        <div class="col">
           
        </div>
    </div>
@endsection
