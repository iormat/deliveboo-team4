@extends('layouts.main-layout')

@section('content')

<div class="container">    
    <chart-month-component></chart-month-component>
    <chart-month-orders-component></chart-month-orders-component>
    <chart-month-profit-component></chart-month-profit-component>
    <chart-year-component></chart-year-component>
    <chart-year-orders-component></chart-year-orders-component>
    <chart-year-profit-component></chart-year-profit-component>
</div>
 


@endsection