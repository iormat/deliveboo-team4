@extends('layouts.main-layout')

@section('content')
 
        <restaurants-component user="{{Auth::check()}}"></restaurants-component>

@endsection