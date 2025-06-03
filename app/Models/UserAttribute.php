<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttribute extends Model
{
    public $timestamps = false;

    protected $table = 'user_attribute';
    protected $connection = 'pgsql2';
    protected $fillable = [
        'id',
        'name',
        'value',
        'user_id'
    ];
}