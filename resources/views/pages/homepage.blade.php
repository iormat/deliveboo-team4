@extends('layouts.main-layout')

@section('content')
    
    @auth
        <a href="{{ route('logout') }}">LOGOUT</a>
    @else
        <a href="{{ route('login-register') }}">REGISTRATI O ACCEDI</a>
    @endauth

    <my-header-component-due></my-header-component-due>

    <homepage-component :restaurants ="{{$restaurants}}"></homepage-component>

@endsection
