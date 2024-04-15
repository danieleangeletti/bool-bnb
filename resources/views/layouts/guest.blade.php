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
                                <li class="nav-item mx-2">
                                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                            @else
                                <li class="nav-item mx-2">
                                    <a class="nav-link hov-underline" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item mx-2">
                                    <a class="nav-link hov-underline" href="{{ route('register') }}">Registrati</a>
                                </li>
                            @endauth
                        </ul>
                        
                        @auth
                            <form method="POST" class="m-0" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit" class="btn btn-turn-back">
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
    <style>
        .hov-underline {
           position: relative;
           display: inline-block;
           font-size: 1.2  rem;
           //padding-bottom: 3px;
           cursor: pointer;
           border-bottom: 2px solid transparent;
           transition: border-color 0.3s ease; /* Aggiungi una transizione fluida per l'effetto hover */
           &:hover{
               transform: scale(1.1);
           }
       }
       /* Animazione per la sottolineatura */
       .hov-underline::after {
       content: '';
           position: absolute;
           left: 0;
           bottom: 0;
           width: 0; /* Inizia senza larghezza */
           height: 2px; /* Altezza della sottolineatura */
           background-color: #EB5A63; 
           transition: width 0.3s ease; /* Aggiungi una transizione fluida per l'animazione */
           transform: scale(1.1);
       }
       .hov-underline:hover::after {
           width: 100%; /* Espandi la larghezza al 100% durante l'hover */
           
       }
   </style>
</html>
