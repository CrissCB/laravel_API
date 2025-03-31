<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria_Emprendimiento extends Model
{
    //use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_cat';

    protected $table = 'categoria_emprendimiento';
    protected $fillable = [

        'estado',
        'descripcion',
        'nombre'

    ];
}
