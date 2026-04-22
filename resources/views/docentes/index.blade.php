@extends('layout')

@section('content')
<div class="mb-5 flex items-center justify-between gap-3">
    <h2 class="text-3xl font-bold">Lista de Docentes</h2>
    <a href="{{ route('docentes.create') }}" class="btn btn-primary">Nuevo Docente</a>
</div>

<div class="card bg-base-100 shadow-xl">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre del docente</th>
                        <th class="w-52">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($docentes as $docente)
                    <tr>
                        <td>{{ $docente->nombre_docente }}</td>
                        <td class="space-x-2 whitespace-nowrap">
                            <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('docentes.destroy', $docente) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-error btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="py-8 text-center text-base-content/70">No hay docentes registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection