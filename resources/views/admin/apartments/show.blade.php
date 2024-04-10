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

        <div class="mb-4">

            <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary">
                Torna alla Home
            </a>
            <p class="mt-2">
               VIsualizzazioni appartamento: {{ $apartmentStats }}
            </p>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div>
                    <h1>{{ $apartment->name }}</h1>
                    <h4>{{ $apartment->type_of_accomodation }}</h4>
                    <p>{{ $apartment->address }}</p>
                    <p>Grandezza alloggio: {{ $apartment->mq }}m²</p>
                    <p>Prezzo: {{ $apartment->price }}€ per notte</p>
                    <p>{{ $apartment->n_guests }} Ospiti | {{ $apartment->n_rooms }} Stanze | {{ $apartment->n_beds }} Letti
                        | {{ $apartment->n_baths }} Bagni</p>

                    <p>Servizi presenti:
                        @foreach ($apartment->services as $service)
                            @if (count($apartment->services) == 1)
                                <span>
                                    {{ $service->type_of_service }}
                                </span>
                            @else
                                <span>
                                    {{ $service->type_of_service }},
                                </span>
                            @endif
                        @endforeach
                    </p>
                </div>

            </div>

            <div class="col-md-5">
                <div style="max-height: 60vh;" class="overflow-hidden">
                    <img src="{{ $apartment->full_cover_img }}" class="img-fluid w-100 rounded" alt="">
                </div>
            </div>


        </div>

        <div class="row justify-content-between align-items-end">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Aggiungi un modulo di acquisto qui -->
                        <form action="{{ route('admin.checkout', ['apartment' => $apartment->id]) }}" method="GET">
                            @csrf
                            <select id="sponsorship_id" name="sponsorship_id" class="form-select mb-3">
                                <option value="">Scegli la tua sponsorship</option>
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
                            <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
                            <button type="submit" class="btn btn-success">BUY</button>
                        </form>
                    </div>
                </div>
            </div>
            {{-- <a class="btn btn-primary" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample">
                Messaggi ricevuti
            </a>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" tabindex="-1"
                aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Email ricevute:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    @foreach ($messages as $message)
                        <h4>
                            Email: {{ $message->email }}
                        </h4>
                        <h5>
                            Nome: {{ $message->name }}
                        </h5>
                        <p>
                            Testo: {{ $message->text }}
                        </p>
                        <form action="{{ route('admin.messages.is_read', ['message' => $message->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit">Contrassegna come letto</button>
                        </form>
                    @endforeach
                </div>
            </div> --}}
        </div>
    </div>
    </div>
    <div class="container mt-4 ">
        <div class=" row ">
            <div class=" col-12">
                <h2 class=" text-center text-primary  title-box-email "> Casella Postale del Tuo appartamento</h2>
            </div>
        </div>


        <div class=" container d-flex flex-wrap box-email">
        
                @foreach ($messages as $message)
                    <div class=" card-email p-3 mb-5 shadow bg-body-tertiary rounded {{$message->is_read ? 'bg-email-read': 'bg-email-not-read'}}">
                        <h5 class="badge text-bg-primary ">{{ $message->email }}</h5>
                        <p class="card-subtitle mb-2 text-body-secondary"> Nome: {{ $message->name }}</p>
                        <p class="card-subtitle mb-2 text-body-secondary"> Cognome: {{ $message->last_name }}</p>
                        
                        <div>
                            <div>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{$message->id}}">
                                    Leggi
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{$message->id}}" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                    {{ $message->email }}</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $message->text }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Chiudi</button>
                                                <form
                                                    action="{{ route('admin.messages.is_read', ['message' => $message->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-secondary">Contrassegna come
                                                        letto</button>
                                                </form>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div> 
                @endforeach

        
        </div>
    </div>


    </div>


@endsection
