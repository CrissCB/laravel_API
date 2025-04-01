<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_producto extends Model
{
    use HasFactory; 
    
    public $timestamps = false;
    protected $primaryKey = 'id_cat';

    protected $table = 'categoria_producto';

    protected $fillable = [
        'estado',
        'descripcion',
        'nombre'
    ];
}