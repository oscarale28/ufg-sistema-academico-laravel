@extends('layout')

@section('content')
    <h2 class="mb-3">Nuevo Alumno</h2>

    <form action="{{ route('alumnos.store') }}" method="POST">
        @csrf

        <input class="form-control mb-2" name="nie" value="{{ old('nie') }}" placeholder="NIE" required>
        <input class="form-control mb-2" name="nombres" value="{{ old('nombres') }}" placeholder="Nombres" required>
        <input class="form-control mb-2" name="apellidos" value="{{ old('apellidos') }}" placeholder="Apellidos" required>
        <input class="form-control mb-2" type="number" min="1" max="120" name="edad" value="{{ old('edad') }}" placeholder="Edad" required>

        <select class="form-control mb-2" name="sexo" required>
            <option value="">Seleccione sexo</option>
            <option value="Masculino" @selected(old('sexo') === 'Masculino')>Masculino</option>
            <option value="Femenino" @selected(old('sexo') === 'Femenino')>Femenino</option>
        </select>

        <input class="form-control mb-2" name="direccion" value="{{ old('direccion') }}" placeholder="Dirección" required>
        <input class="form-control mb-2" name="telefono" value="{{ old('telefono') }}" placeholder="Teléfono" required>
        <input class="form-control mb-2" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
        <input class="form-control mb-3" name="responsable" value="{{ old('responsable') }}" placeholder="Responsable" required>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection
