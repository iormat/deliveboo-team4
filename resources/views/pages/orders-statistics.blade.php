@extends('layouts.dashboard-layout')

@section('content')
<section id="statistics">
    <div class="charts">    
        <h1>Statistiche Mensili</h1>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 g-5 my-5">
                <h5>Statistiche generali per mese:</h5>
                <chart-month-component></chart-month-component>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 g-5 my-5">
                <h5>Statistiche degli ordini per mese:</h5>
                <chart-month-orders-component></chart-month-orders-component>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 g-5 my-5">
                <h5>Statistiche delle vendite per mese:</h5>
                <chart-month-profit-component></chart-month-profit-component>
            </div>
        </div>
        <h1>Statistiche Annuali</h1>
        
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4 g-5 my-5">
                <h5>Statistiche generali per anno</h5>
                <chart-year-component></chart-year-component>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 g-5 my-5">
                <h5>Statistiche degli ordini per anno:</h5>
                <chart-year-orders-component></chart-year-orders-component>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4 g-5 my-5">
                <h5>Statistiche delle vendite per anno</h5>
                <chart-year-profit-component></chart-year-profit-component>
            </div>
        </div>
    </div>
</section>
 
@endsection