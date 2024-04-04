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
                                    {{ $apartment->type_of_accomodation }}
                                </h3>
                            </li>
                            <li>
                                {{ $apartment->address }}
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
                                Numero di servizi disponibili:

                                @foreach ($apartment->services as $singleService)
                                @if(count($apartment->services) == 1 )
                                    <span>
                                        {{ $singleService->type_of_service }}
                                    </span>
                                @else
                                <span>
                                    {{ $singleService->type_of_service }},
                                </span>
                                @endif
                                @endforeach


                            </li>
                            <li>
                                Numero di bagni: {{ $apartment->n_baths }}
                            </li>
                            <li>
                                <img src="{{ $apartment->full_cover_img }}" alt="">
                            </li>
                            <form action="{{ route('admin.checkout') }}" method="GET">
                                @csrf
                                <div class="mt-3 d-flex">
                                    <select id="sponsorship_id" name="sponsorship_id" class="form-select w-25 me-3">
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
                                </div>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
