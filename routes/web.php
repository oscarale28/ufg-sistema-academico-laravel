<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\MateriaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('alumnos.index');
});

Route::resource('alumnos', AlumnoController::class)->except(['show']);
Route::resource('docentes', DocenteController::class)->except(['show']);
Route::resource('materias', MateriaController::class)->except(['show']);

Route::get('horarios', [HorarioController::class, 'index'])->name('horarios.index');
Route::get('horarios/registro/{docente?}', [HorarioController::class, 'detalle'])->name('horarios.registro');
Route::post('horarios/registro', [HorarioController::class, 'guardarRegistro'])->name('horarios.registro.guardar');
