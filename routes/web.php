<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('usuarios', 'UsuarioController@index')->name('usuarios');
Route::post('listarUsuarios', 'UsuarioController@listarUsuarios')->name('listaUsuario');
Route::post('crearUsuario', 'UsuarioController@crearUsuario')->name('crearUsuario');
Route::post('editarUsuario', 'UsuarioController@editarUsuario')->name('editarUsuario');
Route::post('bloquearUsuario', 'UsuarioController@bloquearUsuario')->name('bloquearUsuario');
Route::post('desbloquearUsuario', 'UsuarioController@desbloquearUsuario')->name('desbloquearUsuario');
Route::post('eliminarUsuario', 'UsuarioController@eliminarUsuario')->name('eliminarUsuario');

Route::get('costos', 'CostoController@index')->name('costos');
Route::post('listarCostos', 'CostoController@listarCostos')->name('listarCostos');
Route::post('bloquearCosto', 'CostoController@bloquearCosto')->name('bloquearCosto');
Route::post('desbloquearCosto', 'CostoController@desbloquearCosto')->name('desbloquearCosto');
Route::post('eliminarCosto', 'CostoController@eliminarCosto')->name('eliminarCosto');