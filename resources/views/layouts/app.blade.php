<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMMS - Gestión de Mantenimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <span class="font-bold text-blue-600 text-lg tracking-tight">CMMS</span>
            <div class="flex gap-6 text-sm font-medium text-gray-600">
                <a href="{{ route('activos.index') }}" class="hover:text-blue-600 transition">Activos</a>
                <a href="{{ route('mantenimiento.index') }}" class="hover:text-blue-600 transition">Mantenimientos</a>
                <a href="{{route('paros.index')}}" class="hover:text-blue-600 transition">Paros de Equipo</a>
                <a href="{{route('repuestos.index')}}" class="hover:text-blue-600 transition">Repuestos</a>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-8">
        @yield('content')
    </main>

</body>

</html>