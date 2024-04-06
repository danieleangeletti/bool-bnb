@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('main-content')
    <div class="row">
        <div class="col">
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
        </div>
    </div>
@endsection
