@extends('layouts.main-layout')

@section('content')
    

    <a href="{{ route('login-register') }}">REGISTRATI O ACCEDI</a>

    @auth
    
    <a href="{{ route('logout') }}">LOGOUT</a>
        
    @endauth

@endsection