<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioMateria extends Model
{
    protected $table = 'horario_materia';

    protected $fillable = [
        'docente_id',
        'materia_id',
        'dia',
        'hora_inicio',
        'hora_fin',
    ];

    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }
}
