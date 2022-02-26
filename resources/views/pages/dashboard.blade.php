@extends('layouts.main-layout');

@section('content')
    

   

    <h1>CIAO {{Auth::user() -> name}}</h1>

    

   

@endsection