<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('nick')->unique();
            // $table->string('email')->unique();
            $table->string('email')->default('');
            $table->string('password');
            $table->boolean('bloqueado')->default(false);
            $table->boolean('eliminado')->default(false);
            $table->enum('rol', ['ROL_BASICO', 'ROL_ADMINISTRADOR']);
            $table->enum('genero', ['MASCULINO', 'FEMENINO', 'OTRO']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
