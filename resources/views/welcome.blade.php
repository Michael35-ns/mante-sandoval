<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CMMS - Gestión de Mantenimiento</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                *, :after, :before { box-sizing: border-box; margin: 0; padding: 0; border: 0; }
                body { font-family: 'Instrument Sans', sans-serif; background: #FDFDFC; color: #1b1b18; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem; }
                @media (prefers-color-scheme: dark) { body { background: #0a0a0a; color: #EDEDEC; } }
            </style>
        @endif
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex flex-col items-center justify-center min-h-screen p-6 lg:p-8">

        {{-- Header con acceso --}}
        <header class="w-full max-w-4xl flex justify-between items-center mb-10">
            <span class="text-lg font-semibold tracking-tight text-[#1b1b18] dark:text-[#EDEDEC]">
                CMMS
            </span>
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('activos.index') }}"
                   class="px-4 py-1.5 border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b] rounded-sm text-[#1b1b18] dark:text-[#EDEDEC] leading-normal transition">
                    Iniciar
                </a>
            </nav>
        </header>

        {{-- Contenido principal --}}
        <main class="w-full max-w-4xl flex flex-col lg:flex-row rounded-lg overflow-hidden shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">

            {{-- Panel izquierdo: texto --}}
            <div class="flex-1 p-8 lg:p-16 bg-white dark:bg-[#161615] flex flex-col justify-between">

                <div>
                    <p class="text-xs font-semibold uppercase tracking-widest text-[#706f6c] dark:text-[#A1A09A] mb-3">
                        Instituto Tecnológico de Costa Rica
                    </p>
                    <h1 class="text-2xl font-semibold mb-2 text-[#1b1b18] dark:text-[#EDEDEC]">
                        Sistema de Gestión de Mantenimiento
                    </h1>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-8 leading-relaxed">
                        Plataforma para registrar activos, órdenes de trabajo, paros y repuestos,
                        y calcular automáticamente indicadores de confiabilidad como MTBF, MTTR y disponibilidad.
                    </p>

                    {{-- Módulos --}}
                    <ul class="flex flex-col gap-3 mb-8">
                        @foreach([
                            ['Activos', 'Registro y seguimiento de equipos industriales', 'activos.index'],
                            ['Mantenimiento', 'Órdenes de trabajo correctivo, preventivo y predictivo', 'mantenimiento.index'],
                            ['Paros', 'Control de tiempos de paro por equipo', 'paros.index'],
                            ['Repuestos', 'Catálogo de materiales y costos de intervención', 'repuestos.index'],
                        ] as [$titulo, $desc, $ruta])
                        <li class="flex items-start gap-3 py-2 border-b border-[#e3e3e0] dark:border-[#3E3E3A] last:border-0">
                            <span class="mt-1 w-2 h-2 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A] shrink-0"></span>
                            <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                <span class="font-medium">{{ $titulo }}</span>
                                <span class="text-[#706f6c] dark:text-[#A1A09A]"> — {{ $desc }}</span>
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Indicadores destacados --}}
                <div class="grid grid-cols-3 gap-3 mb-8">
                    @foreach([
                        ['MTBF', 'Mean Time Between Failures'],
                        ['MTTR', 'Mean Time To Repair'],
                        ['OEE', 'Disponibilidad operacional'],
                    ] as [$kpi, $desc])
                    <div class="border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm px-3 py-2 text-center">
                        <p class="text-sm font-semibold text-[#f53003] dark:text-[#FF4433]">{{ $kpi }}</p>
                        <p class="text-[10px] text-[#706f6c] dark:text-[#A1A09A] mt-0.5 leading-tight">{{ $desc }}</p>
                    </div>
                    @endforeach
                </div>

                {{-- CTA --}}
                <div class="flex gap-3">
                    <a href="{{ route('activos.index') }}"
                       class="inline-block px-5 py-1.5 bg-[#1b1b18] dark:bg-[#eeeeec] border border-black dark:border-[#eeeeec] text-white dark:text-[#1C1C1A] hover:bg-black dark:hover:bg-white text-sm rounded-sm leading-normal transition">
                        Ir al panel
                    </a>
                    <a href="{{ route('activos.index') }}"
                       class="inline-block px-5 py-1.5 border border-[#19140035] dark:border-[#3E3E3A] hover:border-[#1915014a] dark:hover:border-[#62605b] text-[#1b1b18] dark:text-[#EDEDEC] text-sm rounded-sm leading-normal transition">
                        Ver activos
                    </a>
                </div>
            </div>

            {{-- Panel derecho: visual --}}
            <div class="bg-[#fff2f2] dark:bg-[#1D0002] w-full lg:w-[380px] shrink-0 flex flex-col items-center justify-center p-10 gap-6 relative overflow-hidden">

                {{-- Logo Laravel decorativo --}}
                <svg class="w-full text-[#F53003] dark:text-[#F61500] opacity-10 absolute inset-0 scale-150" viewBox="0 0 438 104" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.2036 -3H0V102.197H49.5189V86.7187H17.2036V-3Z" fill="currentColor"/>
                    <path d="M110.256 41.6337C108.061 38.1275 104.945 35.3731 100.905 33.3681C96.8667 31.3647 92.8016 30.3618 88.7131 30.3618C83.4247 30.3618 78.5885 31.3389 74.201 33.2923C69.8111 35.2456 66.0474 37.928 62.9059 41.3333C59.7643 44.7401 57.3198 48.6726 55.5754 53.1293C53.8287 57.589 52.9572 62.274 52.9572 67.1813C52.9572 72.1925 53.8287 76.8995 55.5754 81.3069C57.3191 85.7173 59.7636 89.6241 62.9059 93.0293C66.0474 96.4361 69.8119 99.1155 74.201 101.069C78.5885 103.022 83.4247 103.999 88.7131 103.999C92.8016 103.999 96.8667 102.997 100.905 100.994C104.945 98.9911 108.061 96.2359 110.256 92.7282V102.195H126.563V32.1642H110.256V41.6337Z" fill="currentColor"/>
                </svg>

                {{-- Cards de métricas decorativas --}}
                <div class="relative z-10 w-full space-y-3">
                    @foreach([
                        ['Bomba B-01', 'MTBF', '312.5 h', '#16a34a'],
                        ['Compresor C-01', 'Disponibilidad', '94.2%', '#2563eb'],
                        ['Motor M-05', 'MTTR', '6.0 h', '#d97706'],
                    ] as [$equipo, $indicador, $valor, $color])
                    <div class="bg-white dark:bg-[#161615] bg-opacity-80 dark:bg-opacity-80 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-sm px-4 py-3 flex items-center justify-between shadow-sm">
                        <div>
                            <p class="text-xs font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $equipo }}</p>
                            <p class="text-[10px] text-[#706f6c] dark:text-[#A1A09A]">{{ $indicador }}</p>
                        </div>
                        <p class="text-base font-bold" style="color: {{ $color }}">{{ $valor }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="relative z-10 text-center">
                    <p class="text-[10px] text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-widest">
                        Indicadores calculados automáticamente
                    </p>
                </div>

            </div>
        </main>

        <footer class="mt-8 text-xs text-[#706f6c] dark:text-[#A1A09A]">
            Administración de Mantenimiento I · I Semestre 2026 · TEC
        </footer>

    </body>
</html>