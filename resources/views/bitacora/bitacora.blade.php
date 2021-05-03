@extends('layouts.app')
@section('title','Bitácora')
@section('content')
@section('css')

@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        
        <h2><i class="fas fa-file-signature pb-5" aria-hidden="true"></i> &nbsp; Bitácora de movimientos </h2>
    </div>

    
    <div class='table-responsive-lg'>
        <table id="tablaBitacora" class="table table-striped ">
            <input type="hidden" name="_token" content="{{ csrf_token() }}" value="{{ csrf_token() }}" id="_token">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Acción</th>
                    <th>Tabla</th>
                    <th>Usuario</th>
                    <th>ip</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection
@section('script')
<script src="{{ secure_asset('js/bitacora/bitacora.js') }}?v={{ env('VERSION_CSS_JS') }}"></script>
@endsection