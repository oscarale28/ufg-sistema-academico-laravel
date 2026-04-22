# CRUD EN EL FRAMEWORKS LARAVEL CON PHP Y MYSQL,

# PARA LA TABLA ALUMNOS (MVC)

**1. Crear proyecto Laravel**
composer create-project laravel/laravel proyecto
cd proyecto
php artisan serve
**2. Configurar base de datos**
En el archivo .env:
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
**3. Crear modelo, migración y controlador**
php artisan make:model Alumno -mcr
**4. Migración (database/migrations/xxxx_create_alumnos_table.php)**
public function up()
{
Schema::create('alumnos', function (Blueprint $table) {
$table->id();
$table->string('nie')->unique();
$table->string('nombres');
$table->string('apellidos');
$table->integer('edad');
$table->string('sexo');
$table->string('direccion');
$table->string('telefgono');
$table->string('email')->unique();
$table->string('responsable');
$table->timestamps();
});
}


Ejecutar:
php artisan migrate
**5. Modelo (app/Models/Alumno.php)**
protected $fillable = [
'nie',
'nombres',
'apellidos',
'edad',
'sexo',
'direccion',
'telefono',
'email',
'responsable'
];

**6. Controlador (app/Http/Controllers/AlumnoController.php)**
use App\Models\Alumno;
use Illuminate\Http\Request;
class AlumnoController extends Controller
{
public function index()
{
$alumnos = Alumno::all();
return view('alumnos.index', compact('alumnos'));
}
public function create()
{
return view('alumnos.create');
}
public function store(Request $request)
{
Alumno::create($request->all());
return redirect()->route('alumnos.index');


## }

public function edit($id)
{
$alumno = Alumno::findOrFail($id);
return view('alumnos.edit', compact('alumno'));
}
public function update(Request $request, $id)
{
$alumno = Alumno::findOrFail($id);
$alumno->update($request->all());
return redirect()->route('alumnos.index');
}
public function destroy($id)
{
Alumno::destroy($id);
return redirect()->route('alumnos.index');
}
}

**7. Rutas (routes/web.php)**
use App\Http\Controllers\AlumnoController;
Route::resource('alumnos', AlumnoController::class);
**8. Vistas con Bootstrap
resources/views/layout.blade.php**
<!DOCTYPE html>
<html>
<head>
<title>CRUD Alumnos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">
</head>
<body>


<div class="container mt-4">
@yield('content')
</div>
</body>
</html>
**INDEX (lista) → alumnos/index.blade.php**
@extends('layout')
@section('content')
<h2>Lista de Alumnos</h2>
<a href="{{ route('alumnos.create') }}" class="btn btn-primary mb-3">Nuevo Alumno</a>
<table class="table table-bordered">
<tr>
<th>NIE</th>
<th>Nombre</th>
<th>Edad</th>
<th>Acciones</th>
</tr>
@foreach($alumnos as $alumno)
<tr>
<td>{{ $alumno->nie }}</td>
<td>{{ $alumno->nombres }} {{ $alumno->apellidos }}</td>
<td>{{ $alumno->edad }}</td>
<td>
<a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-warning">Editar</a>
<form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" style="display:inline"
onsubmit="return confirm('¿Deseas eliminar este alumno?')">
@csrf
@method('DELETE')
<button class="btn btn-danger">Eliminar</button>
</form>
</td>


</tr>
@endforeach
</table>
@endsection
**CREATE → alumnos/create.blade.php**
@extends('layout')
@section('content')
<h2>Nuevo Alumno</h2>
<form action="{{ route('alumnos.store') }}" method="POST">
@csrf
<input class="form-control mb-2" name="nie" placeholder="NIE">
<input class="form-control mb-2" name="nombres" placeholder="Nombres">
<input class="form-control mb-2" name="apellidos" placeholder="Apellidos">
<input class="form-control mb-2" name="edad" placeholder="Edad">
<select class="form-control mb-2" name="sexo" required>
<option value="">Seleccione sexo</option>
<option value="Masculino">Masculino</option>
<option value="Femenino">Femenino</option>
</select>
<input class="form-control mb-2" name="direccion" placeholder="Dirección">
<input class="form-control mb-2" name="telefono" placeholder="Teléfono">
<input class="form-control mb-2" name="email" placeholder="Email">
<input class="form-control mb-2" name="responsable" placeholder="Responsable">
<button class="btn btn-success">Guardar</button>
</form>
@endsection
**EDIT → alumnos/edit.blade.php**
@extends('layout')
@section('content')


<h2>Editar Alumno</h2>
<form action="{{ route('alumnos.update', $alumno->id) }}" method="POST">
@csrf
@method('PUT')
<input class="form-control mb-2" name="nie" value="{{ $alumno->nie }}">
<input class="form-control mb-2" name="nombres" value="{{ $alumno->nombres }}">
<input class="form-control mb-2" name="apellidos" value="{{ $alumno->apellidos }}">
<input class="form-control mb-2" name="edad" value="{{ $alumno->edad }}">
<select class="form-control mb-2" name="sexo" required>
<option value="Masculino" {{ $alumno->sexo == 'Masculino'? 'selected' : '' }}>Masculino</option>
<option value="Femenino" {{ $alumno->sexo == 'Femenino'? 'selected' : '' }}>Femenino</option>
</select>
<input class="form-control mb-2" name="direccion" value="{{ $alumno->direccion }}">
<input class="form-control mb-2" name="telefono" value="{{ $alumno->telefono }}">
<input class="form-control mb-2" name="email" value="{{ $alumno->email }}">
<input class="form-control mb-2" name="responsable" value="{{ $alumno->responsable }}">
<button class="btn btn-primary">Actualizar</button>
</form>
@endsection
Con esto ya haz finalizado el CRUD funcional con:

- Laravel
- MySQL
- Bootstrap
- Operaciones: Crear, Leer, Actualizar y Eliminar


