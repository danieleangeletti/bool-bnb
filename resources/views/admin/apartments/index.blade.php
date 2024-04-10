@extends('layouts.app')

@section('page-title', 'All apartments')

@section('main-content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="">
                    <div class="card-body">
                        <h1 class="text-center text-danger my-5">
                            I tuoi Appartamenti
                        </h1>
                        <div class="row my-5 ">
                            <div class="col-12 d-flex justify-content-around ">
                                <button type="button" class="btn btn-success mt-3">
                                    <a href="{{ route('admin.apartments.create') }}" class="btn btn-success">Aggiungi un
                                        Appartamento</a>
                                </button>


                                <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Appartamenti archiviati
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Archivio Appartamenti
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table">
                                                    <thead  >
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Cover</th>
                                                            <th scope="col">Nome</th>
                                                            <th scope="col">Prezzo</th>
                                                            <th scope="col">Azioni</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($apartments as $apartment)
                                                            @if ($apartment->deleted_at != null)
                                                                <tr>
                                                                    <th scope="row">{{ $apartment->id }}</th>
                                                                    <td>
                                                                        <img src="{{ $apartment->full_cover_img }}"
                                                                            class="cover-img">
                                                                    </td>
                                                                    <td>{{ $apartment->name }}</td>

                                                                    <td>{{ $apartment->price }}</td>
                                                                    <td>
                                                                        <div class="d-flex flex-column">
                                                                            <form class="mt-5"
                                                                                id="deleteForm{{ $apartment->slug }}"
                                                                                action="{{ route('admin.restore', ['slug' => $apartment->slug]) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-danger"
                                                                                    data-bs-target="#deleteConfirmation{{ $apartment->slug }}">
                                                                                    Recupera
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Chiudi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <table class="table shadow-lg p-3 mb-5 bg-body-tertiary rounded">
                            <thead>
                                <tr>

                                    <th scope="col">Cover</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Tipo di Struttura</th>
                                    <th scope="col">Indirizzo</th>
                                    <th scope="col">Sponsorizzato</th>
                                    <th scope="col">Disponibile</th>
                                    <th scope="col">Azioni</th>
                                    <th scope="col">Email ricevute</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apartments as $apartment)
                                    @if ($apartment->deleted_at == null)
                                        <tr class="tr-index-apartment {{ $apartment->availability == 1 ? '' : 'bg-warning !important' }}">

                                            <td>
                                                <img src="{{ $apartment->full_cover_img }}" class="cover-img">
                                            </td>
                                            <td>{{ $apartment->name }}</td>
                                            <td>
                                                {{ $apartment->type_of_accomodation }}
                                            </td>
                                            <td>{{ $apartment->address }}</td>
                             
                                            <td>
                                                
                                                    @if ($apartment->sponsorships->isNotEmpty())
                                                        @foreach ($apartment->sponsorships as $sponsorship)
                                                            <div>
                                                                {{ $sponsorship->title }} - Scadenza: {{ $sponsorship->pivot->end_date }}
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        Sponsor non attiva
                                                    @endif
                                                
                                            </td>
                                            <td class="">
                                                @if($apartment->availability == 1)
                                                <i class="fa-solid fa-check fa-2xl" style="color: #18b215;"></i>
                                                @else
                                                <i class="fa-solid fa-x fa-2xl" style="color: #ed1707;"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div class="ms-1 me-1 my-1 ">
                                                        <a href="{{ route('admin.apartments.show', ['apartment' => $apartment->slug]) }}"
                                                            class="btn btn-primary">SHOW</a>
                                                        <span class="">

                                                        </span>
                                                    </div>
                                                    <div class="ms-1 me-1 my-1">
                                                        <a href="{{ route('admin.apartments.edit', ['apartment' => $apartment->slug]) }}"
                                                            class="btn btn-warning">EDIT</a>
                                                    </div>
                                                    <div class="ms-1 me-1 my-1">
                                                        {{-- <form onsubmit="return confirm('Are you sure you want to delete this project?')" action="{{route ('admin.apartments.destroy', ['apartment' => $apartment->slug])}}" method="POST" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE') --}}
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-toggle="offcanvas"
                                                            data-bs-target="#deleteConfirmation{{ $apartment->id }}">
                                                            ARCHIVIO
                                                        </button>

                                                        <div class="offcanvas offcanvas-end d" tabindex="-1"
                                                            id="deleteConfirmation{{ $apartment->id }}">
                                                            <div class="offcanvas-header">
                                                                <h5 class="offcanvas-title"
                                                                    id="deleteConfirmationLabel{{ $apartment->id }}">
                                                                    Conferma archiviazione
                                                                </h5>
                                                                <button type="button" class="btn-close text-reset"
                                                                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                            </div>
                                                            <div class="offcanvas-body">
                                                                <p>Vuoi realmente arcvhiviare questo appartamento?
                                                                <h5 class=" d-inline-block ">{{ $apartment->name }}</h5> ?
                                                                </p>
                                                                <form class="mt-5" id="deleteForm{{ $apartment->slug }}"
                                                                    action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->slug]) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Conferma
                                                                        archiviazione</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        {{-- </form> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td scope="row" class="text-center">
                                                <button type="button" class="btn  position-relative">
                                                    <a class=" text-decoration-none "
                                                        href="{{ route('admin.apartments.show', ['apartment' => $apartment->slug]) }}">
                                                        @if ($apartment->unreadMessagesCount() > 0)
                                                            <i class="fa-solid fa-envelope fa-xl"
                                                                style="color: #0c2c64;"></i> <span
                                                                class=" counter-email">{{ $apartment->unreadMessagesCount() }}</span>
                                                            {{-- <span
                                                                class="position-absolute top-50 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                                                <span
                                                                    class="visually-hidden">{{ $apartment->unreadMessagesCount() }}
                                                                    new messages</span>
                                                            </span> --}}
                                                        @else
                                                            <i class="fa-solid fa-envelope-open fa-xl"
                                                                style="color: #0c2c64;"></i>
                                                        @endif
                                                </button>

                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>


@endsection
