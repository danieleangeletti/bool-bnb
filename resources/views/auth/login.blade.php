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
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="container d-flex flex-column  align-items-center">
           
            <div class=" w-50 h-50 d-flex flex-column  align-items-center">
                <img src="{{ asset('img/Immagine_WhatsApp_2024-04-03_ore_14.06.30_25a33b0a.jpg') }}" class=" h-50 w-50 " alt="">
            </div>
        <!-- Email Address -->
        <div>
          
            <label for="email">
                Email
            </label>
            <input class="form-control" type="email" id="email" name="email" required maxlength="255">
            @error('email')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4  ">
            <label for="password">
                Password
            </label>
            <input class="form-control" type="password" id="password" name="password" required>
            @error('password')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mt-4">
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Remember me</span>
            </label>
        </div>

        <div class="mt-4 d-flex flex-column ">
            <button type="submit" class=" mx-3 my-3 btn btn-primary rounded-4 ">
                Log in
            </button>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Password dimenticata?') }}
                </a>
            @endif

           
        </div>
    </div>
    </form>
@endsection
