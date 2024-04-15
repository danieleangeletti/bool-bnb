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

            <div
                class=" position-absolute top-50 start-50 translate-middle d-flex flex-column justify-content-center align-items-center ">
                <div class=" w-100 h-50 d-flex flex-column  align-items-center">
                    <img src="{{ asset('img/loghi/boolbnb-rosa-sfondobianco-600px.JPG') }}" class=" h-25 w-50 pt-1"
                        alt="">
                </div>
                <!-- Name -->
                <div class="w-25">
                    <label for="name">
                        Nome
                    </label>
                    <input class="form-control" value="{{ old('name') }}" type="text" id="name" name="name" maxlength="255">
                    @error('name')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Last name --}}
                <div class="mt-2 w-25">
                    <label for="last_name">
                        Cognome
                    </label>
                    <input class="form-control" value="{{ old('last_name') }}" type="text" id="last_name" name="last_name" maxlength="255">
                    @error('last_name')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Date of birth --}}
                <div class="mt-2 w-25">
                    <label for="date_of_birth">
                        Data di nascita<span class="text-danger">*</span>
                    </label>
                    <input class="form-control" value="{{ old('date_of_birth') }}" type="date" id="date_of_birth" name="date_of_birth">
                    @error('date_of_birth')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mt-2 w-25">
                    <label for="email">
                        Email<span class="text-danger">*</span>
                    </label>
                    <input class="form-control" value="{{ old('email') }}" type="email" id="email" name="email" required
                        maxlength="255">
                    @error('email')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
           

             
                     <!-- Password -->
                <div class="mt-2 w-25">
                    <label for="password">Password<span class="text-danger">*</span></label>
                    <input class="form-control" type="password" id="password"  minlength="8" name="password"  required>
                    <div id="password-error" class="alert alert-danger" style="display:none;"></div>
                    @error('password')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-2 w-25">
                    <label for="password_confirmation">Conferma Password<span class="text-danger">*</span></label>
                    <input class="form-control" type="password" id="password_confirmation"  minlength="8" name="password_confirmation"  required>
                    <div id="password-confirmation-error" class="alert alert-danger" style="display:none;"></div>
                     @error('password_confirmation')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="m-2 d-flex flex-column ">

                    <button type="submit" class=" mx-3 my-3 btn btn-primary rounded-4 ">
                        Registrati
                    </button>
                    <a href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

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
                if(passwordInput.value.length < 8){
                    event.preventDefault();
                    passwordError.style.display = 'block';
                    passwordError.textContent = 'La password deve contenere almeno 8 caratteri.';
                }
                else if (passwordInput.value !== passwordConfirmationInput.value) {
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
