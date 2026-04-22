<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistema Académico</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-base-200">
    <div class="drawer lg:drawer-open">
        <input id="app-sidebar" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content">
            <header class="navbar border-b border-base-300 bg-base-100 px-4 lg:px-8">
                <div class="flex-none lg:hidden">
                    <label for="app-sidebar" class="btn btn-square btn-ghost drawer-button" aria-label="Abrir menu">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block h-6 w-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
            </header>

            <main class="p-4 md:p-8">
                @if (session('success'))
                <div role="alert" class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div role="alert" class="alert alert-error mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>

        <div class="drawer-side z-40">
            <label for="app-sidebar" aria-label="Cerrar menu" class="drawer-overlay"></label>
            @include('partials.sidebar')
        </div>
    </div>
</body>

</html>