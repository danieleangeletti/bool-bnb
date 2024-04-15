@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('main-content')
    <div class="row justify-content-center">
        <div class=" d-flex flex-column align-items-center ">
            <div class=" w-75 h-75 d-flex justify-content-center">
                <img src="{{ asset('img/loghi/boolbnb-rosa-sfondobianco-300px.JPG') }}" class=" w-50 h-75 logo-dashboard p-3 mb-5  rounded" alt="">
            </div>
            <div class=" user-name-dashboard mt-2 p-3 mb-5 rounded">
                    <h1 class="text-center">
                        Ciao {{ auth()->user()->name }}!
                    </h1>
            </div>
        </div>
    </div>
    
    {{-- <div class="row">
        <div class="col">
           
        </div>
    </div> --}}
@endsection
