<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Costo extends Model
{

    use Notifiable;
    
    protected $table = 'costos';

    protected $fillable = [
        'id',
        'descripcion',
        'costo',
        'fecha',
        'bloqueado',
        'eliminado',
    ];
}
