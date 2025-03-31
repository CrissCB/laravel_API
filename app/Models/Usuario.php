<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    //use HasFactory;
    public $timestamps = false;

    protected $table = 'usuario';
    protected $fillable = [

        'nombre',
        'apellido',
        'identificacion',
        'codigo_estudiantil',
        'programa',
        'estado',
        'fecha_nacimiento',
        'sexo',
        'direccion',
        'telefono',
        'redes_sociales',
        'email'

    ];
}
