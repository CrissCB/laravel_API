<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feria_emprendimiento extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'feria_emprendimiento';

    protected $fillable = [
        'id_feria',
        'id_emprendimiento'
    ];
}
