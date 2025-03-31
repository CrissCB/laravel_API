<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'producto';

    protected $fillable = [
        'id_emprendimiento',
        'nombre',
        'detalle',
        'precio',
        'stock',
        'fecha_elaboracion',
        'fecha_vencimiento',
        'talla',
        'codigo_qr',
        'estado',
        'id_cat'
    ];
}
