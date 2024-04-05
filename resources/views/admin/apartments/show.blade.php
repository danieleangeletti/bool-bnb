@extends('layouts.app')

@section('page-title', $apartment->name)

@section('main-content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">

        <div class="mb-4 d-flex justify-content-end ">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary">
                Torna alla Home
            </a>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div>
                    <h1>{{ $apartment->name }}</h1>
                        <h4>{{ $apartment->type_of_accomodation }}</h4>
                        <p>{{ $apartment->address }}</p>
                        <p>Grandezza alloggio: {{ $apartment->mq }}m²</p>
                        <p>Prezzo: {{ $apartment->price }}€ per notte</p>
                        <p>{{ $apartment->n_guests }} Ospiti | {{ $apartment->n_rooms }} Stanze | {{ $apartment->n_beds }} Letti | {{ $apartment->n_baths }} Bagni</p>

                        <p>Servizi presenti: 
                            @foreach ($apartment->services as $service)
                            @if(count($apartment->services) == 1 )
                            <span>
                                {{ $service->type_of_service }}
                            </span>
                        @else
                        <span>
                            {{ $service->type_of_service }},
                        </span>
                        
                        @endif
                        @endforeach</p>
                </div>

            </div>

            <div class="col-md-5">
                <div style="max-height: 60vh;" class="overflow-hidden">
                    <img src="{{ $apartment->full_cover_img }}" class="img-fluid w-100 p-3 rounded" alt="">
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Aggiungi un modulo di acquisto qui -->
                        <form action="{{ route('admin.checkout') }}" method="GET">
                            @csrf
                            <select id="sponsorship_id" name="sponsorship_id" class="form-select mb-3">
                                <option value="">Choose sponsorship</option>
                                @for ($i = 0; $i < count($sponsorships); $i++)
                                    @if ($i == 2)
                                        <option value="{{ $sponsorships[$i]->id }}">{{ $sponsorships[$i]->title }}
                                            {{ '144' }}h: {{ $sponsorships[$i]->cost }}€</option>
                                    @endif
                                    @if ($i < 2)
                                        <option value="{{ $sponsorships[$i]->id }}">{{ $sponsorships[$i]->title }}
                                            {{ $sponsorships[$i]->hour_duration }}h:
                                            {{ $sponsorships[$i]->cost }}€</option>
                                    @endif
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-success">BUY</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection