<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\HorarioMateria;
use App\Models\Materia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HorarioController extends Controller
{
    public function index(): View
    {
        $horarios = HorarioMateria::query()
            ->with(['docente', 'materia'])
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        $docentes = Docente::orderBy('nombre_docente')->get();

        return view('horarios.index', compact('horarios', 'docentes'));
    }

    /**
     * Formulario de registro/edición de horarios por docente (vista Blade + JS).
     * {docente} opcional: si viene, precarga horarios de ese docente.
     */
    public function detalle(?Docente $docente = null): View
    {
        $docentes = Docente::orderBy('nombre_docente')->get();
        $materias = Materia::orderBy('nombre_materia')->get();
        $idDocenteActual = $docente?->id;
        $itemsPrecargados = [];

        if ($docente) {
            $horarios = HorarioMateria::query()
                ->with('materia')
                ->where('docente_id', $docente->id)
                ->orderBy('materia_id')
                ->orderBy('dia')
                ->orderBy('hora_inicio')
                ->get();

            $grupos = [];
            foreach ($horarios as $horario) {
                $materiaId = $horario->materia_id;

                if (! isset($grupos[$materiaId])) {
                    $grupos[$materiaId] = [
                        'materia_id' => $materiaId,
                        'nombre_materia' => $horario->materia?->nombre_materia ?? 'Materia',
                        'horarios' => [],
                    ];
                }

                $grupos[$materiaId]['horarios'][] = [
                    'dia' => $horario->dia,
                    'hora_inicio' => substr((string) $horario->hora_inicio, 0, 5),
                    'hora_fin' => substr((string) $horario->hora_fin, 0, 5),
                ];
            }

            $itemsPrecargados = array_values($grupos);
        }

        return view('horarios.detalle', [
            'docentes' => $docentes,
            'materias' => $materias,
            'idDocenteActual' => $idDocenteActual,
            'itemsPrecargados' => $itemsPrecargados,
        ]);
    }

    public function guardarRegistro(Request $request): JsonResponse
    {
        $data = $request->validate([
            'docente_id' => ['required', 'integer', 'exists:docentes,id'],
            'items' => ['array'],
        ]);

        $items = $data['items'] ?? [];
        if (count($items) > 5) {
            return response()->json(['success' => false, 'message' => 'No se puede agregar mas de 5 materias por docente.'], 422);
        }

        if (count($items) === 0) {
            return response()->json(['success' => false, 'message' => 'Agrega al menos una materia con horarios.'], 422);
        }

        $franjasPorDia = [];
        $materiasVistas = [];

        foreach ($items as $item) {
            if (! isset($item['materia_id']) || ! is_numeric($item['materia_id'])) {
                return response()->json(['success' => false, 'message' => 'Materia invalida.'], 422);
            }

            $materiaId = (int) $item['materia_id'];
            if (isset($materiasVistas[$materiaId])) {
                return response()->json(['success' => false, 'message' => 'No puedes repetir la misma materia.'], 422);
            }
            $materiasVistas[$materiaId] = true;

            if (! Materia::whereKey($materiaId)->exists()) {
                return response()->json(['success' => false, 'message' => 'Materia no encontrada.'], 422);
            }

            $horarios = $item['horarios'] ?? [];
            if (count($horarios) === 0) {
                return response()->json(['success' => false, 'message' => 'Cada materia debe tener al menos un horario.'], 422);
            }

            $dias = [];

            foreach ($horarios as $horario) {
                $dia = $horario['dia'] ?? '';
                $horaInicio = $horario['hora_inicio'] ?? '';
                $horaFin = $horario['hora_fin'] ?? '';

                if ($dia === '' || $horaInicio === '' || $horaFin === '') {
                    return response()->json(['success' => false, 'message' => 'Completa dia, hora inicio y hora fin en todos los horarios.'], 422);
                }

                if ($horaInicio >= $horaFin) {
                    return response()->json(['success' => false, 'message' => 'La hora de inicio debe ser menor a la hora fin.'], 422);
                }

                if (in_array($dia, $dias, true)) {
                    return response()->json(['success' => false, 'message' => 'No se puede repetir el dia en una misma materia.'], 422);
                }
                $dias[] = $dia;

                $franjasPorDia[$dia][] = ['inicio' => $horaInicio, 'fin' => $horaFin];
            }
        }

        foreach ($franjasPorDia as $dia => $franjas) {
            usort($franjas, fn(array $a, array $b): int => strcmp($a['inicio'], $b['inicio']));
            for ($i = 0; $i < count($franjas) - 1; $i++) {
                if ($franjas[$i + 1]['inicio'] < $franjas[$i]['fin']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Hay horarios solapados el dia {$dia}.",
                    ], 422);
                }
            }
        }

        DB::transaction(function () use ($data, $items): void {
            HorarioMateria::where('docente_id', $data['docente_id'])->delete();

            foreach ($items as $item) {
                foreach ($item['horarios'] ?? [] as $horario) {
                    HorarioMateria::create([
                        'docente_id' => $data['docente_id'],
                        'materia_id' => (int) $item['materia_id'],
                        'dia' => $horario['dia'],
                        'hora_inicio' => strlen($horario['hora_inicio']) === 5 ? $horario['hora_inicio'] . ':00' : $horario['hora_inicio'],
                        'hora_fin' => strlen($horario['hora_fin']) === 5 ? $horario['hora_fin'] . ':00' : $horario['hora_fin'],
                    ]);
                }
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Horarios guardados correctamente.',
            'redirect' => route('horarios.registro', [
                'docente' => $data['docente_id'],
                'guardado' => 1,
            ]),
        ]);
    }
}
