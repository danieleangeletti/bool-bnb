@extends('layouts.app')

@section('page-title', 'All apartments')

@section('main-content')

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center text-success">
                        All apartments 
                    </h1>

                    <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary w-100">ADD APARTMENT</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Cover</th>
                                <th scope="col">Name</th>
                                <th scope="col">Type of accomodation</th>
                                <th scope="col">Mq</th>
                                <th scope="col">Address</th>
                                <th scope="col">Number of guests</th>
                                <th scope="col">Number of rooms</th>
                                <th scope="col">Number of beds</th>
                                <th scope="col">Number of baths</th>
                                <th scope="col">Services</th>
                                <th scope="col">Price</th>
                                <th scope="col">Available</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apartments as $apartment)
                                <tr class="{{$apartment->availability == 1 ? '' : 'bg-warning !important'}}">
                                    <th scope="row">{{ $apartment->id }}</th>
                                    <td>
                                        <img src="{{ $apartment->full_cover_img }}" class="cover-img">
                                    </td>
                                    <td>{{ $apartment->name }}</td>
                                    <td>
                                        {{ $apartment->type_of_accomodation }}
                                    </td>
                                    <td>{{ $apartment->mq }}</td>
                                    <td>{{ $apartment->address }}</td>
                                    <td>
                                        {{ $apartment->n_guests }}
                                    </td>
                                    <td>{{ $apartment->n_rooms }}</td>
                                    <td>{{ $apartment->n_beds }}</td>
                                    <td>{{ $apartment->n_baths }}</td>
                                    <td>
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
                                </td>
                                    <td>{{ $apartment->price }}</td>
                                    <td class="{{$apartment->availability == 1 ? 'bg-success' : 'bg-danger'}}"></td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <div class="ms-1 me-1 my-1 ">
                                                <a href="{{ route('admin.apartments.show', ['apartment' => $apartment->slug]) }}" class="btn btn-primary">SHOW</a>
                                            </div>
                                            <div class="ms-1 me-1 my-1">
                                                <a href="{{ route('admin.apartments.edit', ['apartment' => $apartment->slug]) }}" class="btn btn-warning">EDIT</a>
                                            </div>
                                            <div class="ms-1 me-1 my-1">
                                                <form onsubmit="return confirm('Are you sure you want to delete this project?')" action="{{route ('admin.apartments.destroy', ['apartment' => $apartment->slug])}}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                        <button type="button" class="btn btn-danger" data-bs-toggle="offcanvas"
                                            data-bs-target="#deleteConfirmation{{ $apartment->id }}">
                                            Elimina
                                        </button>

                                        <div class="offcanvas offcanvas-end d" tabindex="-1"
                                            id="deleteConfirmation{{ $apartment->id }}">
                                            <div class="offcanvas-header">
                                                <h5 class="offcanvas-title" id="deleteConfirmationLabel{{ $apartment->id }}">
                                                    Conferma eliminazione
                                                </h5>
                                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="offcanvas-body">
                                                <p>Vuoi davvero eliminare <h5 class=" d-inline-block ">{{ $apartment->name }}</h5> ?</p>
                                                <form class="mt-5" id="deleteForm{{ $apartment->slug }}"
                                                    action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->slug]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Conferma eliminazione</button>
                                                </form>
                                            </div>
                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection