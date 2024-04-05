@extends('layouts.guest')

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

    <form id="registrationForm" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name">
                Name
            </label>
            <input value="{{ old('name') }}" type="text" id="name" name="name" maxlength="255">
            @error('name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
            @enderror
        </div>

        {{-- Last name --}}
        <div class="mt-4">
            <label for="last_name">
                Last name
            </label>
            <input value="{{ old('last_name') }}" type="text" id="last_name" name="last_name" maxlength="255">
            @error('last_name')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
            @enderror
        </div>

        {{-- Date of birth --}}
        <div class="mt-4">
            <label for="date_of_birth">
                Date of birth
            </label>
            <input value="{{ old('date_of_birth') }}" type="date" id="date_of_birth" name="date_of_birth">
            @error('date_of_birth')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email">
                Email
            </label>
            <input value="{{ old('email') }}" type="email" id="email" name="email" required maxlength="255">
            @error('email')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">
                Password
            </label>
            <input type="password" id="password" name="password" minlength="8" required>
            @error('password')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation">
                Conferma Password
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" required>
            @error('password_confirmation')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div>
            <a href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit">
                Register
            </button>
        </div>
        <script>
            document.getElementById("registrationForm").addEventListener("submit", function(event) {
            var dataNascita = new Date(document.getElementById("date_of_birth").value);
            var oggi = new Date();
            var eta = oggi.getFullYear() - dataNascita.getFullYear();
            var mese = oggi.getMonth() - dataNascita.getMonth();
            if (mese < 0 || (mese === 0 && oggi.getDate() < dataNascita.getDate())) {
                eta--;
            }
            if (eta < 18) {
                alert("Devi essere maggiorenne per iscriverti.");
                event.preventDefault(); // Impedisce l'invio del form
            }
            });
        </script>
    </form>
@endsection
