@extends('layouts.guest')

@section('main-content')
    @foreach ($errors->all() as $error)
        <ul class="error-ul" class="p-0">
            <li class="error-li">{{ $error }}</li>
        </ul>
    @endforeach

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name">
                Name
            </label>
            <input value="{{ old('name') }}" type="text" id="name" name="name" required maxlength="255">
        </div>

        {{-- Last name --}}
        <div class="mt-4">
            <label for="last_name">
                Last name
            </label>
            <input value="{{ old('last_name') }}" type="text" id="last_name" name="last_name" required maxlength="255">
        </div>

        {{-- Date of birth --}}
        <div class="mt-4">
            <label for="date_of_birth">
                Date of birth
            </label>
            <input value="{{ old('date_of_birth') }}" type="date" id="date_of_birth" name="date_of_birth" required>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email">
                Email
            </label>
            <input value="{{ old('email') }}" type="email" id="email" name="email" required maxlength="255">
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">
                Password
            </label>
            <input type="password" id="password" name="password" required>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation">
                Conferma Password
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div>
            <a href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit">
                Register
            </button>
        </div>
    </form>
@endsection
