@extends('layout')

@section('content')
<div class="mx-auto max-w-2xl">
    <h2 class="mb-5 text-3xl font-bold">Editar Materia</h2>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <form action="{{ route('materias.update', $materia) }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <input class="input input-bordered w-full" name="nombre_materia" value="{{ old('nombre_materia', $materia->nombre_materia) }}" placeholder="Nombre de la materia" required>

                <div class="mt-2 flex gap-2">
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('materias.index') }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection