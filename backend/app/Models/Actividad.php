<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actividad extends Model
{
    protected $table = 'actividades';
    protected $fillable = [
        'titulo',
        'descripcion',
        'lugar',
        'idioma',
        'edad_maxima',
        'edad_minima',
        'hora',
        'fecha',
        'imagen'
    ];

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'usu_activ')
            ->withTimestamps();
    }
}
