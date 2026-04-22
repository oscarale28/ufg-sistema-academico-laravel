<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocenteController extends Controller
{
    public function index(): View
    {
        $docentes = Docente::orderBy('nombre_docente')->get();

        return view('docentes.index', compact('docentes'));
    }

    public function create(): View
    {
        return view('docentes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_docente' => ['required', 'string', 'max:255'],
        ]);

        Docente::create($validated);

        return redirect()->route('docentes.index')->with('success', 'Docente creado correctamente.');
    }

    public function edit(Docente $docente): View
    {
        return view('docentes.edit', compact('docente'));
    }

    public function update(Request $request, Docente $docente): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_docente' => ['required', 'string', 'max:255'],
        ]);

        $docente->update($validated);

        return redirect()->route('docentes.index')->with('success', 'Docente actualizado correctamente.');
    }

    public function destroy(Docente $docente): RedirectResponse
    {
        $docente->delete();

        return redirect()->route('docentes.index')->with('success', 'Docente eliminado correctamente.');
    }
}
