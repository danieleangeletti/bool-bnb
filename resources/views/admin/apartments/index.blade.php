@extends('layouts.app')

@section('page-title', 'All apartments')

@section('main-content')

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container container-index">
        <div class="row">
            <div class="col">


                <h1 class="text-center text-danger">
                    I tuoi Appartamenti
                </h1>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($apartments as $apartment)
                        @if ($apartment->deleted_at == null)
                            <div class="col">
                                <div class="card shadow ">
                                    @if (!empty($apartment->full_cover_img))
                                        <img src="{{ $apartment->full_cover_img }}" class="card-img-top" alt="Cover Image">
                                    @else
                                        <img src="{{ asset('img/loghi/boolairbnb-favicon.PNG') }}"
                                            class="card-img-top object-fit-contain " alt="Default Cover Image">
                                    @endif
                                    <div id="scrollbar2" class="card-body ">
                                        <strong class="card-title">Nome appartamento: <strong>{{ $apartment->name }}</strong></strong>
                                        <p class="card-text">
                                            <strong>Tipo di Struttura:</strong>
                                            {{ $apartment->type_of_accomodation }} <br>
                                            <strong>Indirizzo:</strong> {{ $apartment->address }} <br>
                                            <strong>Sponsorizzato:</strong>
                                            @if ($apartment->sponsorships->isNotEmpty())
                                                @foreach ($apartment->sponsorships as $sponsorship)
                                                    {{ $sponsorship->title }} - Scadenza:
                                                    {{ $sponsorship->pivot->end_date }} <br>
                                                @endforeach
                                            @else
                                                Sponsor non attiva <br>
                                            @endif
                                            <strong>Disponibile:</strong>
                                            @if ($apartment->availability == 1)
                                                <i class="fa-solid fa-check" style="color: #18b215;"></i>
                                            @else
                                                <i class="fa-solid fa-x" style="color: #ed1707;"></i>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="card-footer p-0">
                                        <div class="d-flex justify-content-between align-items-center  ">
                                            <div>
                                                <a href="{{ route('admin.apartments.show', ['apartment' => $apartment->slug]) }}"
                                                    class="btn btn-link" title="Visualizza"><i class="fa-solid fa-eye fa-xl"
                                                        style="color: #000000;"></i></a>
                                                <a href="{{ route('admin.apartments.edit', ['apartment' => $apartment->slug]) }}"
                                                    class="btn btn-link" title="Modifica"><i
                                                        class="fa-solid fa-pencil fa-xl"></i></a>
                                                <button type="button" class="btn btn-link" title="Archivia"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#deleteConfirmation{{ $apartment->id }}"><i
                                                        class="fa-solid fa-trash-can fa-xl"
                                                        style="color: #ff470a;"></i></button>
                                                <div class="offcanvas offcanvas-end " tabindex="-1"
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
                                                        <p>Vuoi realmente archiviare questo appartamento?
                                                        <h5 class=" d-inline-block ">{{ $apartment->name }}</h5> ?
                                                        </p>
                                                        <form class="mt-5" id="deleteForm{{ $apartment->slug }}"
                                                            action="{{ route('admin.apartments.destroy', ['apartment' => $apartment->slug]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Conferma
                                                                archiviazione
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-link text-decoration-none "
                                                    title="Messaggi">
                                                    <a class="position-relative w-25"
                                                        href="{{ route('admin.apartments.show', ['apartment' => $apartment->slug]) }}">
                                                        @if ($apartment->unreadMessagesCount() > 0)
                                                            <i class="fa-solid fa-envelope fa-xl "
                                                                style="color: #0c2c64;"></i> <span
                                                                class="counter-email">{{ $apartment->unreadMessagesCount() }}</span>
                                                        @else
                                                            <i class="fa-solid fa-envelope-open fa-xl"
                                                                style="color: #0c2c64;"></i>
                                                        @endif
                                                    </a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div>
                    <button type="button" class="btn-turn-back" data-bs-toggle="modal" data-bs-target="#my-modal">
                        Appartamenti
                        archiviati
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="my-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table">
                                        <thead>
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
                                                                    <button type="submit" class="btn btn-danger"
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
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Chiudi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Imposta un'altezza fissa per le righe della griglia */
        .card {
            width: 300px;
            height: 450px;
            /* Altezza fissa per tutte le card */
            margin: 10px;


            /* Aggiungi margine tra le card */
            .card-img-top {
                padding: 10px;
                height: 200px;
                /* Altezza desiderata per l'immagine */
                object-fit: cover;
                /* Assicura che l'immagine venga ridimensionata per adattarsi */
            }
        }
    </style>

@endsection
