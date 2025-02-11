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
        'edad',
        'fecha',
        'imagen'
    ];

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'usu_activ')
            ->withTimestamps();
    }
}
