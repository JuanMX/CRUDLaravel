@extends('layouts.app')
@section('title','Usuarios')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        <h1><i class="fa fa-users" aria-hidden="true"></i> &nbsp; CRUD 1: Un CRUD de usuarios normal</h1>

    </div>

    
    <div class='table-responsive-xxl pt-5'>
    <div class="float-right pb-5">
        <button type="button" class="btn btn-primary" id="btn_nuevoUsuario" name="btn_nuevoUsuario"><i class="fas fa-user-plus" aria-hidden="true"></i> Nuevo</button>
    </div>
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
@include('usuario.modales.modalCrearUsuario')
@include('usuario.modales.modalEditarUsuario')
@endsection
@section('script')
<script src="{{ secure_asset('js/usuario/usuario.js') }}?v={{ env('VERSION_CSS_JS') }}"></script>
@endsection