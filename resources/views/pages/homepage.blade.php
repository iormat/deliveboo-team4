@extends('layouts.main-layout')

@section('content')
    
    @auth
        <a href="{{ route('logout') }}">LOGOUT</a>
    @else
        <a href="{{ route('login-register') }}">REGISTRATI O ACCEDI</a>
    @endauth

    <section id="restaurants">
        <div class="container">
            <ul class="row">
                @foreach ($restaurants as $restaurant)
                    <li class="col-sm-12 col-md-6 col-lg-4">
                        <a href="{{route('restaurant', $restaurant -> id)}}">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3>Restaurant&colon; {{$restaurant -> business_name}}</h3>
                                    <span>Id&colon; {{$restaurant -> id}}</span>
                                </div>
                                <div class="card-body">
                                    <p>Restaurant description&colon;</p>
                                    {{$restaurant -> business_description}}
                                </div>
                                <div class="card-footer">
                                    Restauran PIVA&colon;
                                    <mark>{{$restaurant -> p_iva}}</mark>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
