<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
        'nombre',
        'apellido1',
        'apellido2',
        'dni',
        'fecha_nacimiento',
        'email',
        'password',
    ];
}
