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
            <div class="col-12 d-flex justify-content-end ">
                <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary">
                    Torna alla Home
                </a>
            </div>
        </div>
        <h1 class="title-apartment text-center mb-5">{{ $apartment->name }}</h1>
        <div class="row d-flex  justify-content-center">
            <div class="col-md-5">
                @if (!empty($apartment->full_cover_img))
                    <img src="{{ $apartment->full_cover_img }}" class="card-img-top "
                        alt="Cover Image">
                @else
                    <img src="{{ asset('img/Immagine_WhatsApp_2024-04-03_ore_14.06.30_25a33b0a.jpg') }}"
                        class="card-img-top" alt="Default Cover Image">
                @endif
            </div>
            <div class="col-md-3">
                <div class=" me-5 ">
                    <h4>{{ $apartment->type_of_accomodation }}</h4>
                    <p>{{ $apartment->address }}</p>
                    <p>Grandezza alloggio: {{ $apartment->mq }}m²</p>
                    <p>Prezzo: {{ $apartment->price }}€ per notte</p>
                    <p>{{ $apartment->n_guests }} Ospiti | {{ $apartment->n_rooms }} Stanze | {{ $apartment->n_beds }}
                        Letti
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
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="p-3 shadow rounded w-50">
                    <div class="card-body">
                        <!-- Aggiungi un modulo di acquisto qui -->
                        <form action="{{ route('admin.checkout', ['apartment' => $apartment->id]) }}" method="GET">
                            @csrf
                            <select id="sponsorship_id" name="sponsorship_id" class="form-select mb-3 ">
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
        </div>
    </div>
    </div>
    <div class="container mt-5 ">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center text-primary title-box-email"> Casella Postale del Tuo appartamento</h2>
            </div>
        </div>
        <div class=" container d-flex flex-wrap box-email">
            @foreach ($messages as $message)
                <div
                    class=" card-email p-3 mb-5 shadow rounded {{ $message->is_read ? 'bg-email-read' : 'bg-email-not-read' }}">
                    <h5 class="badge text-bg-primary ">{{ $message->email }}</h5>
                    <p class="card-subtitle mb-2 text-body-secondary"> Nome: {{ $message->name }}</p>
                    <p class="card-subtitle mb-2 text-body-secondary"> Cognome: {{ $message->last_name }}</p>
                    <div>
                        <div>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal{{ $message->id }}">
                                Leggi
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $message->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <div class=" row mt-5 shadow">
            <div class="col-12 d-flex flex-column justify-content-center  align-items-center">
                <div class="title-chart">
                    <h3>Andamento del tuo appartamento</h3>
                </div>
                <div class="container-chart">
                    <canvas id="apartmentChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('apartmentChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Totale Visualizzazioni appartamento', 'Totale messaggi ricevuti'],
                datasets: [{
                    label: 'Statistiche dell\'Appartamento',
                    data: [{{ $apartmentStats }}, {{ $apartment->messages()->count() }}],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <style>
        .title-apartment{
                color: rgb(234, 78, 89)
             }   
        .title-chart{
            color: rgb(234, 78, 89)
        }
        .container-chart{
            height: 400px;
        }
    </style>
@endsection
