<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora';
    
    protected $fillable = [
    	'idUsuario',
        'ip',
        'tipoAccion',
        'descripcion',
        'tabla',
        'created_at'
    ];
}
