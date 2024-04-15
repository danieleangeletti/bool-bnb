@extends('layouts.guest')

@section('main-content')
    <div class="row">
        <div class="col">
            <div class="">
                <div class="border-white d-flex flex-column align-items-center   ">
                    <div class=" w-25  h-50 ">
                        <img src="{{ asset('img/loghi/boolbnb-rosa-sfondobianco-600px.JPG') }}" class=" h-100 w-100 " alt="">
                    </div>
                    <div>
                        <h4 class="text-center mt-5">
                            Benvenuto nella tua area personale di BoolBnB
                        </h4>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
