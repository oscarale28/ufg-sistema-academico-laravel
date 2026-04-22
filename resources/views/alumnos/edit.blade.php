@extends('layout')

@section('content')
    <h2 class="mb-3">Editar Alumno</h2>

    <form action="{{ route('alumnos.update', $alumno) }}" method="POST">
        @csrf
        @method('PUT')

        <input class="form-control mb-2" name="nie" value="{{ old('nie', $alumno->nie) }}" placeholder="NIE" required>
        <input class="form-control mb-2" name="nombres" value="{{ old('nombres', $alumno->nombres) }}" placeholder="Nombres" required>
        <input class="form-control mb-2" name="apellidos" value="{{ old('apellidos', $alumno->apellidos) }}" placeholder="Apellidos" required>
        <input class="form-control mb-2" type="number" min="1" max="120" name="edad" value="{{ old('edad', $alumno->edad) }}" placeholder="Edad" required>

        <select class="form-control mb-2" name="sexo" required>
            <option value="Masculino" @selected(old('sexo', $alumno->sexo) === 'Masculino')>Masculino</option>
            <option value="Femenino" @selected(old('sexo', $alumno->sexo) === 'Femenino')>Femenino</option>
        </select>

        <input class="form-control mb-2" name="direccion" value="{{ old('direccion', $alumno->direccion) }}" placeholder="Dirección" required>
        <input class="form-control mb-2" name="telefono" value="{{ old('telefono', $alumno->telefono) }}" placeholder="Teléfono" required>
        <input class="form-control mb-2" type="email" name="email" value="{{ old('email', $alumno->email) }}" placeholder="Email" required>
        <input class="form-control mb-3" name="responsable" value="{{ old('responsable', $alumno->responsable) }}" placeholder="Responsable" required>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
