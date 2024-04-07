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

        <div class="mb-4 d-flex justify-content-around">
            <a class="btn btn-primary" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                Messaggi ricevuti
            </a>
            <div id="offcanvasExample" class="offcanvas offcanvas-start" tabindex="-1" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Email ricevute:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    @foreach ($messages as $message)
                    <h4>
                       Email: {{$message->email}}
                    </h4>
                    <h5>
                       Nome: {{$message->name}}
                    </h5>
                    <p>
                      Testo: {{$message->text}}
                    </p>
                    <form action="{{ route('admin.messages.is_read', ['message' => $message->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit">Contrassegna come letto</button>
                    </form>
                    @endforeach
                   
                    {{-- <button type="button" onclick="openModal()">Rispondi</button> --}}
                </div>
            </div>
        </div>

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
            {{-- <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Rispondi al messaggio</h2>
                    <!-- Form per la risposta -->
                    <form action="{{ route('admin.messages.reply') }}" method="POST">
                        @csrf
                        <!-- Inserisci qui gli input del form per la risposta -->
                        <textarea name="reply_content" rows="4" cols="50"></textarea><br>
                        <input type="hidden" name="message_id" value="{{ $messages }}"> <!-- Assicurati di passare l'ID del messaggio a cui stai rispondendo -->
                        <button type="submit">Invia risposta</button>
                    </form>
                </div>
            </div> --}}

        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Aggiungi un modulo di acquisto qui -->
                        <form action="{{ route('admin.checkout') }}" method="GET">
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
                            <button type="submit" class="btn btn-success">BUY</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        // Funzione per aprire la modale
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }
    
        // Funzione per chiudere la modale
        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }
    
        // Chiudi la modale cliccando sull'area esterna
        window.onclick = function(event) {
            var modal = document.getElementById("myModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script> --}}
@endsection
