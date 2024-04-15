@extends('layouts.guest')

@section('main-content')
    <div class="container">
        <div class="d-flex  flex-column justify-content-center align-items-center  ">
            <div class=" w-50 h-50 d-flex flex-column  align-items-center mb-5">
                <img src="{{ asset('img/loghi/boolbnb-rosa-trasparente-300px.PNG') }}" class=" h-75 w-75 " alt="">
            </div>
            <div class="mt-2 w-50">
                <h5> {{ __('Hai dimenticato la tua password? Nessun problema. Fornisci il tuo indirizzo email e ti invieremo un link per il ripristino della password che ti permetterà di sceglierne una nuova.') }}
                </h5>
            </div>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div class="mt-2 w-25">
                    <label for="email">
                        <strong>
                            Email
                        </strong>
                    </label>
                    <input type="email" id="email" name="email">
                </div>

                <div>
                    <button type="submit" class="btn-turn-back">
                        Email Password Reset Link
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
