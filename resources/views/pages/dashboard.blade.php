@extends('layouts.dashboard-layout')

@section('content')
    

   

    <h1>CIAO {{Auth::user() -> name}}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <dashboard-menu-component></ashboard-menu-component>

    

   

@endsection