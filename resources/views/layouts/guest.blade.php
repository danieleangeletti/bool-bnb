<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite('resources/js/app.js')
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg bg-white">
                <div class="container">
                    <div class="box-img-logo">
                        <img src="{{ asset('img/loghi/boolbnb-rosa-sfondobianco-150px.JPG') }}" class=" h-100 w-100 " alt="">
                    </div>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link text-primary " href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-primary " href="{{ route('register') }}">Registrati</a>
                                </li>
                            @endauth
                        </ul>

                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="btn btn-outline-danger">
                                    Log Out
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </nav>
        </header>

        <main class="py-4">
            <div class="container">
                @yield('main-content')
            </div>
        </main>
    </body>
</html>
