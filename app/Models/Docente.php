<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends Model
{
    protected $fillable = [
        'nombre_docente',
    ];

    public function horarios(): HasMany
    {
        return $this->hasMany(HorarioMateria::class);
    }
}
