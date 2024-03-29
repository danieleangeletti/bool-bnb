@extends('layouts.app')

@section('page-title', $apartment->name)

@section('main-content')

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <ul>
                            <li>
                                <h1>
                                   {{ $apartment->name }} 
                                </h1>
                                <h3>
                                    {{  $apartment->type_of_accomodation }}
                                </h3>                                
                            </li>
                            <li>
                                {{  $apartment->address }}
                            </li>
                            <li>
                                Prezzo: {{ $apartment->price }} per notte
                            </li>
                            <li>
                                Numero di ospiti ammessi: {{ $apartment->n_guests }}
                            </li>
                            <li>
                                Numero delle camere: {{ $apartment->n_rooms }}
                            </li>
                            <li>
                                Numero di letti disponibili: {{ $apartment->n_beds }}
                            </li>
                            <li>
                                Numero di bagni: {{ $apartment->n_baths }}
                            </li>
                            <li>
                                <img src="{{ $apartment->img_cover_path }}" alt=""> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection