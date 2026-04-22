<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MateriaController extends Controller
{
    public function index(): View
    {
        $materias = Materia::orderBy('nombre_materia')->get();

        return view('materias.index', compact('materias'));
    }

    public function create(): View
    {
        return view('materias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_materia' => ['required', 'string', 'max:255', 'unique:materias,nombre_materia'],
        ]);

        Materia::create($validated);

        return redirect()->route('materias.index')->with('success', 'Materia creada correctamente.');
    }

    public function edit(Materia $materia): View
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, Materia $materia): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_materia' => ['required', 'string', 'max:255', 'unique:materias,nombre_materia,' . $materia->id],
        ]);

        $materia->update($validated);

        return redirect()->route('materias.index')->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy(Materia $materia): RedirectResponse
    {
        $materia->delete();

        return redirect()->route('materias.index')->with('success', 'Materia eliminada correctamente.');
    }
}
