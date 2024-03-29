@extends('layouts.guest')

@section('main-content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name">
                Name
            </label>
            <input type="text" id="name" name="name">
        </div>

        {{-- Last name --}}
        <div class="mt-4">
            <label for="last_name">
                Last name
            </label>
            <input type="text" id="last_name" name="last_name">
        </div>

        {{-- Date of birth --}}
        <div class="mt-4">
            <label for="date_of_birth">
                Date of birth
            </label>
            <input type="date" id="date_of_birth" name="date_of_birth">
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email">
                Email
            </label>
            <input type="email" id="email" name="email">
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">
                Password
            </label>
            <input type="password" id="password" name="password">
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation">
                Conferma Password
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation">
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
