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
        <div class="container w-50 d-flex flex-column  align-items-center p-3 mb-5 rounded">
           
            <div class=" w-50 h-50 d-flex flex-column  align-items-center mb-5">
                <img src="{{ asset('img/loghi/boolbnb-rosa-trasparente-300px.PNG') }}" class=" h-75 w-75 " alt="">
            </div>
        <!-- Email Address -->
        <div class="w-50">
          
            <label for="email">
                <strong>Email</strong>
            </label>
            <input class="form-control" type="email" id="email" name="email" required maxlength="255">
            @error('email')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4 w-50 ">
            <label for="password">
               <strong>Password</strong> 
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
            <button type="submit" class=" mx-3 my-3 btn-turn-back rounded-4 ">
                Log in
            </button>
            @if (Route::has('password.request'))
                <a class=" text-decoration-none text-black hov-underline mx-5" href="{{ route('password.request') }}">
                    {{ __('Password dimenticata?') }}
                </a>
            @endif

           
        </div>
    </div>
    </form>
@endsection
