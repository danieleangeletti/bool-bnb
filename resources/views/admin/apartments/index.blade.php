@extends('layouts.app')

@section('page-title', 'All apartments')

@section('main-content')
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
                                <th scope="col">Address</th>
                                <th scope="col">Number of guests</th>
                                <th scope="col">Number of rooms</th>
                                <th scope="col">Number of beds</th>
                                <th scope="col">Number of baths</th>
                                <th scope="col">Price</th>
                                <th scope="col">Availability</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apartments as $apartment)
                                <tr>
                                    <th scope="row">{{ $apartment->id }}</th>
                                    <td>
                                        <img src="{{ $apartment->img_cover_path }}" class="cover-img">
                                    </td>
                                    <td>{{ $apartment->name }}</td>
                                    <td>
                                        {{ $apartment->type_of_accomodation }}
                                    </td>
                                    <td>{{ $apartment->address }}</td>
                                    <td>
                                        {{ $apartment->n_guests }}
                                    </td>
                                    <td>{{ $apartment->n_rooms }}</td>
                                    <td>{{ $apartment->n_beds }}</td>
                                    <td>{{ $apartment->n_baths }}</td>
                                    <td>{{ $apartment->price }}</td>
                                    <td>{{ $apartment->availability }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="ms-1 me-1">
                                                <a href="{{ route('admin.apartments.show', ['apartment' => $apartment->slug]) }}" class="btn btn-primary">SHOW</a>
                                            </div>
                                            <div class="ms-1 me-1">
                                                <a href="{{ route('admin.apartments.edit', ['apartment' => $apartment->slug]) }}" class="btn btn-warning">EDIT</a>
                                            </div>
                                            <div class="ms-1 me-1">
                                                <form onsubmit="return confirm('Are you sure you want to delete this project?')" action="{{route ('admin.apartments.destroy', ['apartment' => $apartment->slug])}}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        DELETE
                                                    </button>
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
@endsection