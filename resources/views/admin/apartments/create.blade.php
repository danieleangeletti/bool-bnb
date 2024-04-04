<script>
    document.addEventListener("DOMContentLoaded", function() {
        let suggestionsContainer = document.getElementById("suggestions");
        const addressInput = document.getElementById("address-input");
        const form = document.getElementById("myForm"); // Ottieni il riferimento al form

         let isChecked = false
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
                    console.log('ciao')
                    event.preventDefault(); // Impedisce l'invio del modulo
                    alert("Devi selezionare un suggerimento dalla lista dei indirizzi!");
                    suggestions.classList.add('is-invalid')
                    return false; // Interrompe l'esecuzione dello script
                }
            });
            document.addEventListener("click", function() {
                console.log('ciao')
                suggestionsContainer.innerHTML = "";
            })
    });
</script>

@extends('layouts.app')

@section('page-title', 'Add apartment')

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
    <div class=" container ">
        <div class="mb-4">
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-primary">
                Torna alla Home
            </a>
        </div>

        <h1>Create Apartment</h1>


        <form id="myForm" action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label ">Add name</label>
                <input value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" type="text"
                    id="name" name="name" maxlength="64" required>
                @error('name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type_of_accomodation" class="form-label">Type of Accomodation</label>
                <select name="type_of_accomodation" id="type_of_accomodation" class="form-select" required>
                    <option value="" {{ old('type_of_accomodation') == null ? 'selected' : '' }}>
                        Add Type of Accomodation
                    </option>
                    @for ($i = 0; $i < count($accomodation); $i++)
                        <option value="{{ $accomodation[$i] }}"
                            {{ old('type_of_accomodation') == $accomodation[$i] ? 'selected' : '' }}>
                            {{ $accomodation[$i]}}
                        </option>
                    @endfor
                    {{-- da chiedere ^ --}}
                </select>
                @error('n_guests')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="n_guests">Number Guests (between 1 and 10):</label>
                <input value="{{ old('n_guests') }}" class="form-control @error('n_guests') is-invalid @enderror"
                    type="number" id="n_guests" name="n_guests" min="1" max="10" required>
                @error('n_guests')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="mq">Mq:</label>
                <input value="{{ old('mq') }}" class="form-control @error('mq') is-invalid @enderror"
                    type="number" id="mq" name="mq" min="20" max="150" required>
                @error('mq')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="n_rooms">Number Rooms (between 1 and 6):</label>
                <input value="{{ old('n_rooms') }}" class="form-control @error('n_rooms') is-invalid @enderror"
                    type="number" id="n_rooms" name="n_rooms" min="1" max="6" required>
                    @error('n_rooms')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
            </div>
            <div class="mb-3">
                <label for="n_beds">Number Beds (between 1 and 9):</label>
                <input value="{{ old('n_beds') }}" class="form-control @error('n_beds') is-invalid @enderror"
                    type="number" id="n_beds" name="n_beds" min="1" max="9" required>
                    @error('n_beds')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
            </div>
            <div class="mb-3">
                <label for="n_baths">Number Baths (between 1 and 3):</label>
                <input value="{{ old('n_baths') }}" class="form-control @error('n_baths') is-invalid @enderror"
                    type="number" id="n_baths" name="n_baths" min="1" max="3" required>
                    @error('n_baths')
                     <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price">Price</label>
                <input value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" type="number"
                    id="price" name="price" min="1.00" max="1000.00" required>
                    @error('price')
                     <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div>
                @foreach ($services as $service)
                    <div class="form-check form-check-inline"> 
                         <input {{--Se c'è l'old, vuol dire che c'è stato un errore --}}
                            {{-- Faccio le verifiche sulla collezione --}}
                            {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                            class="form-check-input" type="checkbox" id="service-{{ $service->id }}" name="services[]"
                            value="{{ $service->id }}">
                        <label class="form-check-label"
                            for="service-{{ $service->id }}">{{ $service->type_of_service }}</label>
                    </div>
                @endforeach
            </div>
            <div class="mb-3 position-relative">
                <label for="address" class="form-label ">Add address</label>
                <input value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror"
                    type="text" id="address-input" name="address" maxlength="64" autocomplete="off">
                    <ul id="suggestions">
                        
                    </ul>
                @error('adress')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="img_cover_path" class="form-label">Apartment image</label>
                <input class="form-control" type="file" id="img_cover_path" name="img_cover_path">

                <div class="mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="delete_img_cover_path" name="delete_img_cover_path">
                        <label class="form-check-label" for="delete_img_cover_path">
                            Remove image
                        </label>
                    </div>
                </div>
            </div>
            {{-- da vedere --}}
            <button type="submit" class="btn btn-success w-100">
                Create
            </button>
    </div>

    </form>

@endsection
