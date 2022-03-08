@extends('layouts.main-layout')

@section('content')
    
    @auth
        <a href="{{ route('logout') }}">LOGOUT</a>
    @else
        <a href="{{ route('login-register') }}">REGISTRATI O ACCEDI</a>
    @endauth

    <homepage-component :restaurants ="{{$restaurants}}"></homepage-component>

@endsection
