<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('idUsuario');
            $table->ipAddress('ip')->default('');
            $table->enum('tipoAccion', ['Login', 'Editar', 'Eliminar']);
            // $table->string('descripcion', 1500)->default('');
            $table->text('descripcion');
            $table->string('tabla', 50)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bitacora');
    }
}
