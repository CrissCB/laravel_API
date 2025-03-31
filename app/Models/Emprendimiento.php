<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprendimiento extends Model
{
    use HasFactory; 
    
    public $timestamps = false;

    protected $table = 'emprendimiento';

    protected $fillable = [
        'id_cat',
        'nombre',
        'marca',
        'descripcion',
        'estado',
        'id_usuario',
        'fecha_inscripcion'
    ];
}
