@extends('layout')

@section('content')
<div class="mb-5 flex items-center justify-between gap-3">
    <h2 class="text-3xl font-bold">Horarios por Docente</h2>
    <a href="{{ route('horarios.registro') }}" class="btn btn-primary">Registrar horarios</a>
</div>

<div class="mb-4 max-w-sm">
    <label class="label" for="filtroDocente">
        <span class="label-text">Filtrar por docente</span>
    </label>
    <select id="filtroDocente" class="select select-bordered w-full">
        <option value="">Todos</option>
        @foreach ($docentes as $docente)
        <option value="{{ $docente->id }}">{{ $docente->nombre_docente }}</option>
        @endforeach
    </select>
</div>

<div class="card bg-base-100 shadow-xl">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Docente</th>
                        <th>Dia</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($horarios as $horario)
                    <tr data-docente-id="{{ $horario->docente_id }}">
                        <td>{{ $horario->materia?->nombre_materia }}</td>
                        <td>{{ $horario->docente?->nombre_docente }}</td>
                        <td>{{ $horario->dia }}</td>
                        <td>{{ substr((string) $horario->hora_inicio, 0, 5) }}</td>
                        <td>{{ substr((string) $horario->hora_fin, 0, 5) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-base-content/70">No hay horarios registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    (function() {
        const filtro = document.getElementById('filtroDocente');
        if (!filtro) return;

        filtro.addEventListener('change', function() {
            const value = this.value;
            document.querySelectorAll('tr[data-docente-id]').forEach((row) => {
                row.classList.toggle('hidden', value !== '' && row.getAttribute('data-docente-id') !== value);
            });
        });
    })();
</script>
@endsection