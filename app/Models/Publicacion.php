<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    //use HasFactory;
    public $timestamps = false;

    protected $table = 'publicaciones';
    protected $fillable = [

        'titulo',
        'descripcion',
        'imagen_url',
        'id_emprendimiento',
        'id_feria',
        'fecha_publicacion',
        'estado'

    ];
}
