<script>
    document.addEventListener("DOMContentLoaded", function() {
        let suggestionsContainer = document.getElementById("suggestions");
        const addressInput = document.getElementById("address-input");
        const form = document.getElementById("myForm"); // Ottieni il riferimento al form
        let isChecked = true
        addressInput.addEventListener("input", function() {
            const input = addressInput.value.trim();
            isChecked = false
            if (input.length === 0) {
                suggestionsContainer.innerHTML = "";
                return;
            }
            fetch(`https://api.tomtom.com/search/2/search/${input}.json?key=03zxGHB5yWE9tQEW9M7m9s46vREYKHct`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = ""; // Svuota i suggerimenti precedenti
                    data.results.forEach(result => {
                        const suggestion = document.createElement("li");
                        suggestion.textContent = result.address.freeformAddress;
                        suggestion.addEventListener("click", function() {
                            addressInput.value = result.address.freeformAddress;
                            suggestionsContainer.innerHTML = "";
                            isChecked = true
                        });
                         suggestionsContainer.appendChild(suggestion);
                    });
                })
                .catch(error => console.error("Errore durante il recupero dei suggerimenti:", error));
            });
            form.addEventListener("submit", function(event) {
                const addressInput = document.getElementById("address-input");
                const suggestions = document.getElementById("suggestions");
                const selectedOption = suggestions.querySelector("option:checked");
                // Se non è stata selezionata alcuna opzione, mostra un messaggio di errore e impedisce l'invio del modulo
                if (isChecked == false) {
                    event.preventDefault(); // Impedisce l'invio del modulo
                    alert("Devi selezionare un suggerimento dalla lista dei indirizzi!");
                    suggestions.classList.add('is-invalid')
                    return false; // Interrompe l'esecuzione dello script
                }
            });
            document.addEventListener("click", function() {
                suggestionsContainer.innerHTML = "";
            })
    });
</script>

@extends('layouts.app')

@section('page-title', $apartment->slug . 'EDIT')

@section('main-content')
{{-- @dd($accomodation); --}}

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class=" container ">

        
        <h1 class=" text-danger  mb-5 text-center ">Modifica il tuo appartamento</h1>
        <form action="{{ route('admin.apartments.update', ['apartment' => $apartment->slug]) }}" id="myForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row my-3">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Aggiungi il nome<span class="text-danger">*</span></label>
                        <input value="{{ old('name', $apartment->name) }}" type="text" class="form-control" id="name"
                        name="name" placeholder="Insert name..." maxlength="100" required>
                        @error('name')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="type_of_accomodation" class="form-label">Type of Accomodation</label>
                        <select name="type_of_accomodation" id="type_of_accomodation" class="form-select" required>
                            <option {{ old('type_of_accomodation', $apartment->type_of_accomodation) == null ? 'selected' : '' }}
                                value="">
                                Scegli il tipo di struttura
                            </option>
        
                            @for ($i = 0; $i < count($accomodation); $i++)
                                <option
                                    {{ $accomodation[$i] }} {{ old('type_of_accomodation', $apartment->type_of_accomodation) == $accomodation[$i] ? 'selected' : '' }}>{{ $accomodation[$i] }}
                                </option>
                            @endfor   
                        </select>
                        @error('type_of_accomodation')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="n_guests" class="form-label">Numero persone ammesse(tra 1 e 10):<span class="text-danger">*</span></label>
                        <input value="{{ old('n_guests', $apartment->n_guests) }}" type="number" min="1" max="10"
                            class="form-control" id="n_guests" name="n_guests" placeholder="Insert n_guests..." required>
                            @error('n_guests')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="n_baths" class="form-label">Numero bagni (tra 1 e 3):<span class="text-danger">*</span></label>
                        <input value="{{ old('n_baths', $apartment->n_baths) }}" type="number" min="1" max="3"
                            class="form-control" id="n_baths" name="n_baths" placeholder="Insert Baths..." required>
                            @error('n_baths')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="row my-3">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="n_rooms" class="form-label">Numero camere(tra 1 e 6):<span class="text-danger">*</span></label>
                        <input value="{{ old('n_rooms', $apartment->n_rooms) }}" type="number" min="1" max="6"
                            class="form-control" id="n_rooms" name="n_rooms" placeholder="Insert rooms...">
                            @error('n_rooms')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="n_beds" class="form-label">Posti letto (tra 1 e 9):<span class="text-danger">*</span></label>
                        <input value="{{ old('n_beds', $apartment->n_beds) }}" type="number" min="1" max="9"
                            class="form-control" id="n_beds" name="n_beds" placeholder="Insert beds...">
                            @error('n_beds')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row my-3">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="mq" class="form-label">Metri quadri(tra 20mq e 150mq):<span class="text-danger">*</span></label>
                        <input value="{{ old('mq', $apartment->mq) }}" type="number" min="20" max="150"
                            class="form-control" id="mq" name="mq" placeholder="Insert mq..." required>
                            @error('mq')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="price" class="form-label">Prezzo per notte(tra 1.00€ e 1000.00€):<span class="text-danger">*</span></label>
                        <input value="{{ old('price', $apartment->price) }}" type="number" min="1,00" max="1000,00"
                            class="form-control" id="price" name="price" placeholder="Insert Price...">
                            @error('price')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row my-3">
                <div class="col-12">
                    <span >Scegli i tuoi servizi:</span>
                    <div class="py-3">
                        @foreach ($services as $service)
                            <div class="form-check form-check-inline"> 
                                <input {{--Se c'è l'old, vuol dire che c'è stato un errore --}}
                                    @if ($errors->any())  {{--Faccio le verifiche sull'old --}}
                                        {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                                    @else 
                                        {{-- Faccio le verifiche sulla collezione --}}
                                        {{ $apartment->services->contains($service->id) ? 'checked' : '' }} 
                                    @endif
                                    class="form-check-input" type="checkbox" id="service-{{ $service->id }}" name="services[]" value="{{ $service->id }}">
                                <label class="form-check-label" for="service-{{ $service->id }}">
                                    {{ $service->type_of_service }}
                                </label>
                            </div>
                        @endforeach
                        @error('services')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="row my-3">
                <div class="col-6">
                    <div class="mb-3 position-relative">
                        <label for="address" class="form-label">Aggiungi indirizzo<span class="text-danger">*</span></label>
                        <input value="{{ old('address', $apartment->address) }}" type="text" class="form-control"
                            id="address-input" name="address" placeholder="Inserisci indirizzo..." maxlength="100" required autocomplete="off">
                        <ul id="suggestions">
        
                        </ul>
                        @error('address')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="img_cover_path" class="form-label">Carica immagine di copertina</label>
                        <input class="form-control" type="file" id="img_cover_path" name="img_cover_path">
        
                        @if ($apartment->img_cover_path != null)
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$apartment->img_cover_path) }}" style="max-width: 400px;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="delete_img_cover_path" name="delete_img_cover_path">
                                    <label class="form-check-label" for="delete_img_cover_path">
                                        Rimuovi immagine
                                    </label>
                                </div>
                            </div>
                        @endif
                        @error('img_cover_path')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="row my-3">
                <div class="col-4">

                    <div class="form-check form-check-inline p-0">
                        <input type="radio" class="btn-check" name="availability" id="success-outlined" autocomplete="off" value="1" {{ old('availability', $apartment->availability) == '1' ? 'checked' : '' }}>
                        <label class="btn btn-outline-success" for="success-outlined">Disponibile</label>
        
                        <input type="radio" class="btn-check"  name="availability" id="danger-outlined" autocomplete="off" value="0" {{ old('availability',$apartment->availability) == '0' ? 'checked' : '' }}>
                        <label class="btn btn-outline-danger" for="danger-outlined">Non disponibile</label>
                    </div>

                </div>
            </div>


            <div class="row">
                <div class="col-12 d-flex  justify-content-center ">
                    <button type="submit" class="btn-turn-back">
                        Modifica
                    </button>
                </div>
            </div>
        </form>

    </div>
@endsection
