@extends('layouts.app')
@section('title','Costo')
@section('content')
@section('css')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        
        <h2><i class="fas fa-dollar-sign" aria-hidden="true"></i> &nbsp; CRUD 2: Un CRUD de costos con <i>details-control y server-side</i></h2>
    </div>

    
    <div class='table-responsive-lg'>
    <div class="float-right pb-3">
        <button type="button" class="btn btn-primary" id="btn_nuevoCosto" name="btn_nuevoCosto"> <i class="fas fa-dollar-sign" aria-hidden="true"></i> Nuevo</button>
    </div>
        <table id="tablaCosto" class="table table-striped table-hover display">
            <input type="hidden" name="_token" content="{{ csrf_token() }}" value="{{ csrf_token() }}" id="_token">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Costo</th>
                    <th>Inicio de vigencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@include('costo.modales.modalCrearCosto')
@include('costo.modales.modalEditarCosto')
@endsection
@section('script')
<script src="{{ secure_asset('js/costo/costo.js') }}?v={{ env('VERSION_CSS_JS') }}"></script>

{{--Para date range picker--}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

{{--Para imask--}}
<script src="https://unpkg.com/imask"></script>
@endsection