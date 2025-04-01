<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaccion extends Model
{
    //use HasFactory;
    public $timestamps = false;

    protected $table = 'interaccion';
    protected $fillable = [

        'id_cliente',
        'id_publicacion',
        'fecha_interaccion',
        'comentarios',
        'calificacion'

    ];
}
