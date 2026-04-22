<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AlumnoController extends Controller
{
    public function index(): View
    {
        $alumnos = Alumno::latest()->get();

        return view('alumnos.index', compact('alumnos'));
    }

    public function create(): View
    {
        return view('alumnos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nie' => ['required', 'string', 'max:255', 'unique:alumnos,nie'],
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'edad' => ['required', 'integer', 'min:1', 'max:120'],
            'sexo' => ['required', 'in:Masculino,Femenino'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', 'unique:alumnos,email'],
            'responsable' => ['required', 'string', 'max:255'],
        ]);

        Alumno::create($validated);

        return redirect()->route('alumnos.index')->with('success', 'Alumno creado correctamente.');
    }

    public function edit(Alumno $alumno): View
    {
        return view('alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, Alumno $alumno): RedirectResponse
    {
        $validated = $request->validate([
            'nie' => ['required', 'string', 'max:255', 'unique:alumnos,nie,' . $alumno->id],
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'edad' => ['required', 'integer', 'min:1', 'max:120'],
            'sexo' => ['required', 'in:Masculino,Femenino'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', 'unique:alumnos,email,' . $alumno->id],
            'responsable' => ['required', 'string', 'max:255'],
        ]);

        $alumno->update($validated);

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno): RedirectResponse
    {
        $alumno->delete();

        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }
}
