@extends('layout')

@section('content')
<div class="mb-5 flex items-center justify-between gap-3">
    <h2 class="text-3xl font-bold">Lista de Materias</h2>
    <a href="{{ route('materias.create') }}" class="btn btn-primary">Nueva Materia</a>
</div>

<div class="card bg-base-100 shadow-xl">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre de la materia</th>
                        <th class="w-52">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($materias as $materia)
                    <tr>
                        <td>{{ $materia->nombre_materia }}</td>
                        <td class="space-x-2 whitespace-nowrap">
                            <a href="{{ route('materias.edit', $materia) }}" class="btn btn-warning btn-sm">Editar</a>
                            <button type="button" class="btn btn-error btn-sm" onclick="document.getElementById('delete_materia_{{ $materia->id }}').showModal()">
                                Eliminar
                            </button>

                            <dialog id="delete_materia_{{ $materia->id }}" class="modal">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">Confirmar eliminación</h3>
                                    <p class="py-3">
                                        ¿Seguro que quieres eliminar la materia <span class="font-semibold">{{ $materia->nombre_materia }}</span>?
                                    </p>
                                    <div class="modal-action">
                                        <form method="dialog">
                                            <button class="btn btn-ghost">Cancelar</button>
                                        </form>
                                        <form action="{{ route('materias.destroy', $materia) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-error">Sí, eliminar</button>
                                        </form>
                                    </div>
                                </div>
                                <form method="dialog" class="modal-backdrop">
                                    <button>Cerrar</button>
                                </form>
                            </dialog>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="py-8 text-center text-base-content/70">No hay materias registradas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection