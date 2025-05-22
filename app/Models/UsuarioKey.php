<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioKey extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'user_entity';
    protected $connection = 'pgsql2';
    protected $appends = ['identificacion'];
    protected $fillable = [
        'id',
        'email',
        'email_constraint',
        'email_verified',
        'enabled',
        'federation_link',
        'first_name',
        'last_name',
        'realm_id',
        'username',
        'created_timestamp',
        'service_account_client_link',
        'not_before'
    ];

    // Relación con los atributos del usuario
    public function attributes()
    {
        return $this->hasMany(UserAttribute::class, 'user_id', 'id');
    }

    // Accesor para fácil obtención de la identificación
    public function getIdentificacionAttribute()
    {
        $identificacion = $this->attributes()
                            ->where('name', 'identificacion')
                            ->first();
        
        return $identificacion ? $identificacion->value : null;
    }
}