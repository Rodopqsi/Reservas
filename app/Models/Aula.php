<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aula extends Model
{
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'capacidad',
        'activo',
        'ubicacion',
        'equipamiento',
    ];

    protected $casts = [
        'equipamiento' => 'array',
        'activo' => 'boolean',
    ];

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}
