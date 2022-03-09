@extends('layouts.main-layout')

@section('content')

<div class="container">    
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 g-5"><chart-month-component></chart-month-component></div>
        <div class="col-sm-12 col-md-6 col-lg-4 g-5"><chart-month-orders-component></chart-month-orders-component></div>
        <div class="col-sm-12 col-md-6 col-lg-4 g-5"><chart-month-profit-component></chart-month-profit-component></div>
        <div class="col-sm-12 col-md-6 col-lg-4 g-5"><chart-year-component></chart-year-component></div>
        <div class="col-sm-12 col-md-6 col-lg-4 g-5"><chart-year-orders-component></chart-year-orders-component></div>
        <div class="col-sm-12 col-md-6 col-lg-4 g-5"><chart-year-profit-component></chart-year-profit-component></div>
    </div>

</div>
 


@endsection