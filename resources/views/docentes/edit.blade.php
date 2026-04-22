@extends('layout')

@section('content')
<div class="mx-auto max-w-2xl">
    <h2 class="mb-5 text-3xl font-bold">Editar Docente</h2>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <form action="{{ route('docentes.update', $docente) }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <input class="input input-bordered w-full" name="nombre_docente" value="{{ old('nombre_docente', $docente->nombre_docente) }}" placeholder="Nombre del docente" required>

                <div class="mt-2 flex gap-2">
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('docentes.index') }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection