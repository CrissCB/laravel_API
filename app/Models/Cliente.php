<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    //use HasFactory;
    public $timestamps = false;

    protected $table = 'cliente';
    protected $fillable = [

        'nombre',
        'apellido',
        'identificacion',
        'estado',
        'fecha_nacimiento',
        'sexo',
        'direccion',
        'telefono',
        'email'
    ];
}
