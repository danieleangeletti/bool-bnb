@extends('layouts.guest')

@section('main-content')
    <div>
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <label for="password">
                Password
            </label>
            <input type="password" id="password" name="password">
        </div>

        <div>
            <button type="btn-turn-back">
                Confirm
            </button>
        </div>
    </form>
@endsection
