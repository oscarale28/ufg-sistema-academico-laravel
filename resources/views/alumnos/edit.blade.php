@extends('layout')

@section('content')
<div class="mx-auto max-w-3xl">
    <h2 class="mb-5 text-3xl font-bold">Editar Alumno</h2>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <form action="{{ route('alumnos.update', $alumno) }}" method="POST" class="grid grid-cols-1 gap-3 md:grid-cols-2">
                @csrf
                @method('PUT')

                <input class="input input-bordered w-full" name="nie" value="{{ old('nie', $alumno->nie) }}" placeholder="NIE" required>
                <input class="input input-bordered w-full" name="nombres" value="{{ old('nombres', $alumno->nombres) }}" placeholder="Nombres" required>
                <input class="input input-bordered w-full" name="apellidos" value="{{ old('apellidos', $alumno->apellidos) }}" placeholder="Apellidos" required>
                <input class="input input-bordered w-full" type="number" min="1" max="120" name="edad" value="{{ old('edad', $alumno->edad) }}" placeholder="Edad" required>

                <select class="select select-bordered w-full" name="sexo" required>
                    <option value="Masculino" @selected(old('sexo', $alumno->sexo) === 'Masculino')>Masculino</option>
                    <option value="Femenino" @selected(old('sexo', $alumno->sexo) === 'Femenino')>Femenino</option>
                </select>

                <input class="input input-bordered w-full" name="telefono" value="{{ old('telefono', $alumno->telefono) }}" placeholder="Teléfono" required>
                <input class="input input-bordered w-full md:col-span-2" name="direccion" value="{{ old('direccion', $alumno->direccion) }}" placeholder="Dirección" required>
                <input class="input input-bordered w-full" type="email" name="email" value="{{ old('email', $alumno->email) }}" placeholder="Email" required>
                <input class="input input-bordered w-full" name="responsable" value="{{ old('responsable', $alumno->responsable) }}" placeholder="Responsable" required>

                <div class="mt-2 flex gap-2 md:col-span-2">
                    <button class="btn btn-primary">Actualizar</button>
                    <a href="{{ route('alumnos.index') }}" class="btn btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection