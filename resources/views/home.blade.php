@extends('layouts.app')
@section('title','Inicio')
@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 ">

            @if(Auth::user()->rol == 'ROL_BASICO')
            <div class="card text-center">
                <div class="card-header"><i class="fas fa-home" aria-hidden="true"></i> &nbsp;
                    Bienvenido(a)
                </div>
                <div class="card-body">
                    <h5 class="card-title">Prueba técnica</h5>
                    <p class="card-text">Sección de inicio de una prueba técnica</p>
                </div>
            </div>
            @else
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ secure_asset('img/uno.png') }}" class="d-block w-100" alt="imagen 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ secure_asset('img/dos.png') }}" class="d-block w-100" alt="imagen 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ secure_asset('img/tres.png') }}"class="d-block w-100" alt="imagen 3">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ secure_asset('img/cuatro.png') }}"class="d-block w-100" alt="imagen 4">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ secure_asset('img/cinco.png') }}"class="d-block w-100" alt="imagen 5">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            @endif

        </div>
    </div>
    
</div>

@endsection