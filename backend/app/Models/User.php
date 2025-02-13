<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';

    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'dni',
        'fecha_nacimiento',
        'password',
    ];

    public function actividades(): BelongsToMany
    {
        return $this->belongsToMany(Actividad::class,'usu_activ')
            ->withTimestamps();
    }
}
