@extends('layouts.dashboard-layout');

@section('content')
    

   

    <h1>CIAO {{Auth::user() -> name}}</h1>
    <dashboard-menu-component></ashboard-menu-component>
    

   

@endsection