<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addressInput = document.getElementById("address-input");
        const suggestionsContainer = document.getElementById("suggestions");

        addressInput.addEventListener("input", function() {
            const input = addressInput.value.trim();

            if (input.length === 0) {
                suggestionsContainer.innerHTML = "";
                return;
            }

            fetch(`https://api.tomtom.com/search/2/search/${input}.json?key=03zxGHB5yWE9tQEW9M7m9s46vREYKHct`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = ""; // Svuota i suggerimenti precedenti

                    data.results.forEach(result => {
                        const suggestion = document.createElement("div");
                        suggestion.textContent = result.address.freeformAddress;
                        suggestion.addEventListener("click", function() {
                            addressInput.value = result.address.freeformAddress;
                            suggestionsContainer.innerHTML = "";
                        });
                        suggestionsContainer.appendChild(suggestion);
                    });
                })
                .catch(error => console.error("Errore durante il recupero dei suggerimenti:", error));
        });
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Create Apartment</h1>


        <form action="{{ route('admin.apartments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label ">Add name</label>
                <input value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" type="text"
                    id="name" name="name" maxlength="64">
                @error('name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type_of_accomodation" class="form-label">Type of Accomodation</label>
                <select name="type_of_accomodation" id="type_of_accomodation" class="form-select">
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
            </div>
            <div class="mb-3">
                <label for="n_guests">Number Guests (between 1 and 10):</label>
                <input value="{{ old('n_guests') }}" class="form-control @error('n_guests') is-invalid @enderror"
                    type="number" id="n_guests" name="n_guests" min="1" max="10">
                @error('n_guests')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="n_rooms">Number Rooms (between 1 and 6):</label>
                <input value="{{ old('n_rooms') }}" class="form-control @error('n_rooms') is-invalid @enderror"
                    type="number" id="n_rooms" name="n_rooms" min="1" max="6">
                <div class="alert alert-danger">
                    @error('n_rooms')
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="n_beds">Number Beds (between 1 and 9):</label>
                <input value="{{ old('n_beds') }}" class="form-control @error('n_beds') is-invalid @enderror"
                    type="number" id="n_beds" name="n_beds" min="1" max="9">
                <div class="alert alert-danger">
                    @error('n_beds')
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="n_baths">Number Baths (between 1 and 9):</label>
                <input value="{{ old('n_baths') }}" class="form-control @error('n_baths') is-invalid @enderror"
                    type="number" id="n_baths" name="n_baths" min="1" max="3">
                <div class="alert alert-danger">
                    @error('n_baths')
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price">Price</label>
                <input value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" type="number"
                    id="price" name="price" min="1.00" max="1000.00">
                <div class="alert alert-danger">
                    @error('price')
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="service_id" class="form-label">Service</label>
                <select name="service_id" id="service_id" class="form-select">
                    <option
                        value=""
                        {{ old('service_id') == null ? 'selected' : '' }}>
                        Add service
                    </option>
                    @foreach ($services as $service)
                        <option
                            value="{{ $service->id }}"
                            {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->type_of_service }}
                        </option>
                    @endforeach
                </select>
            </div>
       
            {{-- <div class="mb-3">
                <label for="latitude" class="form-label ">Add latitude</label>
                <input value="{{ old('latitude') }}" class="form-control @error('latitude') is-invalid @enderror" type="text"
                    id="latitude" name="latitude" maxlength="64">
                @error('latitude')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}
            {{-- <div class="mb-3">
                <label for="longitude" class="form-label ">Add longitude</label>
                <input value="{{ old('longitude') }}" class="form-control @error('longitude') is-invalid @enderror" type="text"
                    id="longitude" name="address" maxlength="64">
                @error('address')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div> --}}
            {{-- <label for="latitude">Latitude:</label><br>
            <input type="text" id="latitude" name="latitude"><br>
            <label for="longitude">Longitude:</label><br>
            <input type="text" id="longitude" name="longitude"><br> --}}
            <div class="mb-3">
                <label for="address" class="form-label ">Add address</label>
                <input value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror"
                    type="text" id="address-input" name="address" maxlength="64">
                    <div id="suggestions">
                        
                    </div>
                @error('adress')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="city" class="form-label ">Add city</label>
                <input value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" type="text"
                    id="city" name="city" maxlength="64">
                @error('city')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="img_cover_path" class="form-label">Apartment image</label>
                <input class="form-control" type="text" id="img_cover_path" name="img_cover_path">
            </div>
            {{-- da vedere --}}
            <button type="submit" class="btn btn-success w-100">
                Create
            </button>
    </div>

    </form>

@endsection
