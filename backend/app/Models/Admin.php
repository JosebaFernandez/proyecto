<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'dni',
        'email',
        'fecha_nacimiento',
        'password',
    ];

    public function actividades(): BelongsToMany
    {
        return $this->belongsToMany(Actividad::class,'usu_activ')
            ->withTimestamps();
    }
}
