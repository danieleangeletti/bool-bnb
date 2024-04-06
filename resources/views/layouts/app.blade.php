<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('page-title') | {{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        @vite('resources/js/app.js')
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg  bg-white ">
                <div class="container bg-white ">
                    <div class="box-img-logo">
                        <img src="{{ asset('img/Immagine_WhatsApp_2024-04-03_ore_14.06.30_25a33b0a.jpg') }}" class=" h-100 w-100 " alt="">
                    </div>
                    {{-- <a class="navbar-brand" href="#">BoolBnb</a> --}}
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="icon-link icon-link-hover text-decoration-none " style="--bs-link-hover-color-rgb: 25, 135, 84;"  href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                    <svg class="bi" aria-hidden="true"><use xlink:href="#arrow-right"></use></svg>
                                  </a>
                          
                            </li>
                            <li class="nav-item">
                                <a class="icon-link icon-link-hover text-decoration-none" style="--bs-link-hover-color-rgb: 25, 135, 84;" href="{{ route('admin.apartments.index') }}">
                                    Appartamenti
                                    <svg class="bi" aria-hidden="true"><use xlink:href="#arrow-right"></use></svg>
                                  </a>

                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="#">Link 2</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link 3</a>
                            </li> --}}
                        </ul>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="btn btn-outline-danger">
                                Log Out
                            </button>
                        </form>
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
