@extends('layouts.main-layout')

@section('content')
    <section id="restaurant_menu">       
        {{-- <ul class="row">
            @foreach ($menu as $dish)
                <li class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>Nome Piatto&colon; {{$dish -> dish_name}}</h3>
                            <span>Id&colon; {{$dish -> id}}</span>
                        </div>
                        <div class="card-body">
                            <p>Descrizione piatto&colon;</p>
                            {{$dish -> description}}
                        </div>
                        <div class="card-footer">
                            Prezzo piatto&colon;
                            <mark>{{$dish -> price}} &euro;</mark>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul> --}}


    <restaurant-menu-component
    :user="{{$user}}"
    ></restaurant-menu-component>

    {{-- {{$user}} --}}

</section>

@endsection