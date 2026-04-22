@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Lista de Alumnos</h2>
        <a href="{{ route('alumnos.create') }}" class="btn btn-primary">Nuevo Alumno</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>NIE</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Responsable</th>
                <th style="width: 170px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->nie }}</td>
                    <td>{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
                    <td>{{ $alumno->edad }}</td>
                    <td>{{ $alumno->sexo }}</td>
                    <td>{{ $alumno->telefono }}</td>
                    <td>{{ $alumno->email }}</td>
                    <td>{{ $alumno->responsable }}</td>
                    <td>
                        <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Deseas eliminar este alumno?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No hay alumnos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
