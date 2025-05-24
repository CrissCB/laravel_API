<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeycloakRole extends Model
{
    public $timestamps = false;
    protected $table = 'keycloak_role';
    protected $connection = 'pgsql2';

    protected $fillable = [
        'id',
        'name',
        'description',
        'realm_id'
    ];



}