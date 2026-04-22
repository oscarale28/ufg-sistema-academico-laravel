<aside class="h-full w-72 bg-base-100 p-4">
    <div class="mb-4 border-b border-base-300 pb-3">
        <h1 class="text-2xl font-bold">SISTEMA ACADÉMICO</h1>
    </div>

    <nav class="space-y-5">
        <div>
            <p class="mb-2 px-2 text-xs font-bold uppercase tracking-wide text-base-content/60">Alumnos</p>
            <ul class="menu rounded-box bg-base-100 p-1 w-full">
                <li>
                    <a href="{{ route('alumnos.index') }}" class="{{ request()->routeIs('alumnos.index') ? 'active' : '' }}">
                        Lista de alumnos
                    </a>
                </li>
                <li>
                    <a href="{{ route('alumnos.create') }}" class="{{ request()->routeIs('alumnos.create') ? 'active' : '' }}">
                        Crear alumno
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <p class="mb-2 px-2 text-xs font-bold uppercase tracking-wide text-base-content/60">Docentes</p>
            <ul class="menu rounded-box bg-base-100 p-1 w-full">
                <li>
                    <a href="{{ route('docentes.index') }}" class="{{ request()->routeIs('docentes.index') ? 'active' : '' }}">
                        Lista de docentes
                    </a>
                </li>
                <li>
                    <a href="{{ route('docentes.create') }}" class="{{ request()->routeIs('docentes.create') ? 'active' : '' }}">
                        Crear docente
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <p class="mb-2 px-2 text-xs font-bold uppercase tracking-wide text-base-content/60">Materias</p>
            <ul class="menu rounded-box bg-base-100 p-1 w-full">
                <li>
                    <a href="{{ route('materias.index') }}" class="{{ request()->routeIs('materias.index') ? 'active' : '' }}">
                        Lista de materias
                    </a>
                </li>
                <li>
                    <a href="{{ route('materias.create') }}" class="{{ request()->routeIs('materias.create') ? 'active' : '' }}">
                        Crear materia
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <p class="mb-2 px-2 text-xs font-bold uppercase tracking-wide text-base-content/60">Horarios</p>
            <ul class="menu rounded-box bg-base-100 p-1 w-full">
                <li>
                    <a href="{{ route('horarios.index') }}" class="{{ request()->routeIs('horarios.index') ? 'active' : '' }}">
                        Horarios de docentes
                    </a>
                </li>
                <li>
                    <a href="{{ route('horarios.registro') }}" class="{{ request()->routeIs('horarios.registro') ? 'active' : '' }}">
                        Registro por docente
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</aside>