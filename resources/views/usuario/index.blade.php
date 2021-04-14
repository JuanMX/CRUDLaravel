@extends('layouts.app')
@section('title','Usuarios')
@section('content')
<title>Usuario</title>
<div class="container">
    <div class="row justify-content-center">
        
        <h1><i class="fa fa-users" aria-hidden="true"></i> &nbsp; CRUD 1: Un CRUD de usuarios normal</h1>

    </div>

    <div class="float-right">
        <button type="button" class="btn btn-primary" id="btn_nuevoUsuario" name="btn_nuevoUsuario"><i class="fa fa-user" aria-hidden="true"></i> Nuevo</button>
    </div>
    <div class='table-responsive-xl pt-5'>
        <table id="tablaUsuario" class="table table-hover">
            <input type="hidden" name="_token" content="{{ csrf_token() }}" value="{{ csrf_token() }}" id="_token">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>email</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    
    
</div>

@endsection
@section('script')
<script src="{{ secure_asset('js/usuario/usuario.js') }}?v={{ env('VERSION_CSS_JS') }}"></script>
@endsection