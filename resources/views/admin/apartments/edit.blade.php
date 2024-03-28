@extends('layouts.app')

@section('page-title', $apartment->title . ' EDIT')

@section('main-content')
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

        <form action="{{ route('admin.apartments.edit', ['apartment' => $apartment->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">name <span class="text-danger">*</span></label>
                <input value="{{ old('name', $apartment->name) }}" type="text" class="form-control" id="name"
                    name="name" placeholder="Insert name..." maxlength="64" required>
            </div>
            <div class="mb-3">
                <label for="type_of_accomodation" class="form-label">Type of Accomodation</label>
                <select name="type_of_accomodation" id="type_of_accomodation" class="form-select">
                    <option {{ old('type_of_accomodation', $apartment->type_of_accomodation) == null ? 'selected' : '' }}
                        value="">
                        Select type of accomodation
                    </option>
                    @for ($i = 0; $i < count($allTypesOfAccomodation); $i++)
                        <option
                            {{ old('type_of_accomodation', $apartment->type_of_accomodation) == $allTypesOfAccomodation[$i] ? 'selected' : '' }}
                            value="{{ $allTypesOfAccomodation[$i] }}">
                            {{ $apartment->type_of_accomodation }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="mb-3">
                <label for="n_guests" class="form-label">Guests <span class="text-danger">*</span></label>
                <input value="{{ old('n_guests', $apartment->n_guests) }}" type="number" min="1" max="10"
                    class="form-control" id="n_guests" name="n_guests" placeholder="Insert n_guests..." required>
            </div>
            <div class="mb-3">
                <label for="n_rooms" class="form-label">Rooms <span class="text-danger">*</span></label>
                <input value="{{ old('n_rooms', $apartment->n_rooms) }}" type="number" min="1" max="6"
                    class="form-control" id="n_rooms" name="n_rooms" placeholder="Insert rooms..." required>
            </div>
            <div class="mb-3">
                <label for="n_beds" class="form-label">Beds <span class="text-danger">*</span></label>
                <input value="{{ old('n_beds', $apartment->n_beds) }}" type="number" min="1" max="9"
                    class="form-control" id="n_beds" name="n_beds" placeholder="Insert beds..." required>
            </div>
            <div class="mb-3">
                <label for="n_baths" class="form-label">Baths <span class="text-danger">*</span></label>
                <input value="{{ old('n_baths', $apartment->n_baths) }}" type="number" min="1" max="3"
                    class="form-control" id="n_baths" name="n_beds" placeholder="Insert Baths..." required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                <input value="{{ old('price', $apartment->price) }}" type="number" min="1.00" max="1000.00"
                    class="form-control" id="price" name="n_beds" placeholder="Insert Price..." required>
            </div>
            <div>
                @foreach ($services as $service)
                    <div class="form-check form-check-inline">
                        <input {{-- Se c'è l'old, vuol dire che c'è stato un errore --}}
                            @if ($errors->any()) {{-- Faccio le verifiche sull'old --}}
                            {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}
                        @else
                            {{-- Faccio le verifiche sulla collezione --}}
                            {{ $apartment->services->contains($service->id) ? 'checked' : '' }} @endif
                            class="form-check-input" type="checkbox" id="service-{{ $service->id }}" name="services[]"
                            value="{{ $service->id }}">
                        <label class="form-check-label"
                            for="service-{{ $service->id }}">{{ $service->type_of_service }}</label>
                    </div>
                @endforeach
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                <input value="{{ old('address', $apartment->address) }}" type="text" class="form-control"
                    id="address" name="address" placeholder="Insert address..." maxlength="64" required>
            </div>

            <div class="mb-3">
                <label for="img_cover_path" class="form-label">Apartment image</label>
                <input class="form-control" type="file" id="img_cover_path" name="img_cover_path">

                @if ($apartment->img_cover_path != null)
                    <div class="mt-2">
                        <h4>
                            Image
                        </h4>
                        <img src="{{ asset('storage/'.$apartment->img_cover_path) }}" style="max-width: 400px;">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="delete_img_cover_path" name="delete_img_cover_path">
                            <label class="form-check-label" for="delete_img_cover_path">
                                Remove image
                            </label>
                        </div>
                    </div>
                @endif
            </div>
            <div>
                <button type="submit" class="btn btn-success">
                    Edit
                </button>
            </div>


        </form>

    </div>
@endsection
