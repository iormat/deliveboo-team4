@extends('layouts.main-layout')

@section('content')
<my-header-component-due></my-header-component-due>
    <section id="restaurantMenu">       

        

        <restaurant-menu-component
        :user="{{$user}}"
        ></restaurant-menu-component>

    </section>
@endsection