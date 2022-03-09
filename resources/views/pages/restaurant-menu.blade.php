@extends('layouts.main-layout')

@section('content')
    <section id="restaurant_menu">       

        <restaurant-menu-component
        :user="{{$user}}"
        ></restaurant-menu-component>

    </section>
@endsection