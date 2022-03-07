@extends('layouts.dashboard-layout')

@section('content')
    

   

    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <dashboard-menu-component></dashboard-menu-component>

@endsection