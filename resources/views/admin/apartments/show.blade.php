@extends('layouts.app')

@section('page-title', $apartment->name)

@section('main-content')
    @php
        $messageCount = count($messages);
        $overflowClass = $messageCount > 10 ? 'overflow-enabled' : '';
    @endphp
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

        <h1 class="title-apartment text-center mb-5">{{ $apartment->name }}</h1>
        <div class="row d-flex  justify-content-center">
            <div class="col-md-3">
                <div class=" me-5 ">
                    <h4>{{ $apartment->type_of_accomodation }}</h4>
                    <p>{{ $apartment->address }}</p>
                    <p> <strong>Grandezza alloggio:</strong> {{ $apartment->mq }}m²</p>
                    <p> <strong> Prezzo:</strong> {{ $apartment->price }}€ per notte</p>
                    <p>{{ $apartment->n_guests }} <strong>Ospiti | </strong>{{ $apartment->n_rooms }} <strong> Stanze |</strong> {{ $apartment->n_beds }}
                       <strong>Letti
                        | </strong> {{ $apartment->n_baths }} <strong>Bagni</strong></p>
                    <p> <strong>Servizi presenti:</strong>
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
                @if (!empty($apartment->full_cover_img))
                <img src="{{ $apartment->full_cover_img }}" class="card-img-top " alt="Cover Image">
            @else
                <img src="{{ asset('img/loghi/boolbnb-rosa-sfondobianco-300px.JPG') }}" class="card-img-top"
                    alt="Default Cover Image">
            @endif
              
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                <div class="p-3 shadow rounded w-50 bg-white ">
                    <div class="card-body ">
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
                            <button type="submit" class="btn-turn-back">BUY</button>
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
                <h2 class="text-center title-apartment title-box-email"> Casella Postale del Tuo appartamento</h2>
            </div>
        </div>
        @php
            $messageCount = count($messages);
            $overflowClass = $messageCount > 10 ? 'overflow-enabled' : '';
        @endphp

        <div class="container">
            <div class="table-responsive {{ $overflowClass }}">
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th class=" ps-4">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($messages as $message)
                            @php
                                $isRead = $message->is_read ? 'read' : 'unread';
                            @endphp
                            <tr class="{{ $isRead }}">
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->last_name }}</td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn-turn-back read-button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $message->id }}">
                                        Leggi

                                    </button>
                                    <span class="status-dot {{ $isRead }}"></span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($messages as $message)
            <!-- Modal -->
            <div class="modal fade" id="exampleModal{{ $message->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $message->email }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{ $message->text }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                            <form action="{{ route('admin.messages.is_read', ['message' => $message->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-secondary">Contrassegna come letto</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class=" row mt-4 shadow">
            <div class="col-12 d-flex flex-column justify-content-center  align-items-center bg-white">
                <div class="title-chart mb-3 ">
                    <h3>Andamento del tuo appartamento</h3>
                </div>
                <div class="container-chart bg-white">
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
                beginAtZero: true,
                ticks: {
                    callback: function(value, index, values) {
                        return parseInt(value).toFixed(0); // Converti il valore in intero e lo formatti
                    },
                    stepSize: 1 // Imposta la dimensione del passo a 1 per evitare numeri decimali
                }
            }
        }
    }
});

    </script>
    <style>
        .title-apartment {
            color: rgb(234, 78, 89)
        }

        .title-chart {
            color: rgb(234, 78, 89)
        }

        .container-chart {
            height: 400px;
        }

        .table-responsive {
            max-height: 400px;
            overflow-x: auto;

            th {
                color: rgb(234, 78, 89);

                td {
                    width: calc(100% / 4) button {
                        margin: 0px !important;
                    }
                }
            }


        }

        .modal-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .modal-dialog {
            max-width: 800px;
        }

        .modal-content {
            overflow: hidden;
        }

        .modal-title {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .overflow-enabled {
            overflow-y: auto;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            background-color: black;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
            opacity: 0;
            animation: pulse 1.5s infinite;
        }

        .status-dot.read {
            display: none;
        }

        .status-dot.unread {
            opacity: 1;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endsection
