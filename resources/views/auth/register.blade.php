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
        <div class="container">
            <div class=" w-100 h-50 d-flex flex-column  align-items-center">
                <img src="{{ asset('img/loghi/boolbnb-rosa-trasparente-300px.PNG') }}" class=" pt-1"
                    alt="">
            </div>
            <div class=" container w-75 d-flex flex-column">
                <div class=" d-flex">
                    <div class="w-50 m-3">
                        <label for="name">
                            <strong>Nome</strong>
                        </label>
                        <input class="form-control" value="{{ old('name') }}" type="text" id="name" name="name"
                            maxlength="255">
                        @error('name')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Last name --}}
                    <div class=" w-50 m-3">
                        <label for="last_name ">
                            <strong>Cognome</strong>
                        </label>
                        <input class="form-control" value="{{ old('last_name') }}" type="text" id="last_name"
                            name="last_name" maxlength="255">
                        @error('last_name')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <!-- Name -->

                <div class=" d-flex my-3 ">
                    {{-- Date of birth --}}
                    <div class=" w-50 m-3">
                        <label for="date_of_birth">
                            <Strong>Data di nascita</Strong><span class="text-danger">*</span>
                        </label>
                        <input class="form-control" value="{{ old('date_of_birth') }}" type="date" id="date_of_birth"
                            name="date_of_birth">
                        @error('date_of_birth')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class=" w-50 m-3">
                        <label for="email">
                            <strong>Email</strong><span class="text-danger">*</span>
                        </label>
                        <input class="form-control" value="{{ old('email') }}" type="email" id="email" name="email"
                            required maxlength="255">
                        @error('email')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class=" d-flex ">

                    <!-- Password -->
                    <div class=" w-50 m-3">
                        <label for="password"><strong>Password</strong><span class="text-danger">*</span></label>
                        <input class="form-control" type="password" id="password" minlength="8" name="password" required>
                        <div id="password-error" class="alert alert-danger" style="display:none;"></div>
                        @error('password')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class=" w-50 m-3">
                        <label for="password_confirmation"><strong>Conferma Password</strong><span
                                class="text-danger">*</span></label>
                        <input class="form-control" type="password" id="password_confirmation" minlength="8"
                            name="password_confirmation" required>
                        <div id="password-confirmation-error" class="alert alert-danger" style="display:none;"></div>
                        @error('password_confirmation')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="">
                    <div class="m-2 d-flex flex-column align-items-center ">
    
                        <button type="submit" class="w-25 mx-3 my-3 rounded-4 btn-turn-back ">
                            Registrati
                        </button>
                        <a class="mx-5 text-decoration-none text-black hov-underline" href="{{ route('login') }}">
                            {{ __('Sei già registrato?') }}
                        </a>
    
                    </div>
                </div>

              

            </div>
        
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
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const passwordError = document.getElementById('password-error');
            const passwordConfirmationError = document.getElementById('password-confirmation-error');
            const submitform = document.getElementById('registrationForm');

            submitform.addEventListener('submit', (event) => {
                if (passwordInput.value.length < 8) {
                    event.preventDefault();
                    passwordError.style.display = 'block';
                    passwordError.textContent = 'La password deve contenere almeno 8 caratteri.';
                } else if (passwordInput.value !== passwordConfirmationInput.value) {
                    event.preventDefault();
                    passwordError.style.display = 'block';
                    passwordError.textContent = 'Le password non coincidono.';
                    passwordConfirmationError.style.display = 'block';
                    passwordConfirmationError.textContent = 'Le password non coincidono.';
                } else {
                    passwordError.style.display = 'none';
                    passwordConfirmationError.style.display = 'none';
                }
            });
        </script>

    </form>
@endsection
