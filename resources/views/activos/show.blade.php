
@extends('layouts.app')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <h1 class="text-2xl font-bold text-gray-800">{{ $activo->nombre }}</h1>
            @if($activo->estado === 'Activo')
                <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Activo</span>
            @else
                <span class="bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">Fuera de servicio</span>
            @endif
        </div>
        <p class="text-sm text-gray-500 font-mono">{{ $activo->codigo }} · {{ $activo->tipo }} · {{ $activo->area }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('activos.edit', $activo) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            Editar
        </a>
        <form action="{{ route('activos.destroy', $activo) }}" method="POST"
              onsubmit="return confirm('¿Eliminar este activo?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                Eliminar
            </button>
        </form>
    </div>
</div>

{{-- Indicadores de confiabilidad --}}
<h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Indicadores de confiabilidad</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">

    <div class="bg-white rounded-xl shadow px-5 py-4 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">MTBF</p>
        @if($mtbf !== null)
            <p class="text-2xl font-bold text-blue-600">{{ number_format($mtbf, 1) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">horas entre fallas</p>
        @else
            <p class="text-xl font-bold text-gray-300">N/A</p>
            <p class="text-xs text-gray-400 mt-0.5">sin fallas registradas</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow px-5 py-4 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">MTTR</p>
        @if($mttr !== null)
            <p class="text-2xl font-bold text-orange-500">{{ number_format($mttr, 1) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">horas promedio reparación</p>
        @else
            <p class="text-xl font-bold text-gray-300">N/A</p>
            <p class="text-xs text-gray-400 mt-0.5">sin correctivos</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow px-5 py-4 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Disponibilidad</p>
        @if($disponibilidad !== null)
            @php $colorDisp = $disponibilidad >= 90 ? 'text-green-600' : ($disponibilidad >= 75 ? 'text-yellow-500' : 'text-red-600'); @endphp
            <p class="text-2xl font-bold {{ $colorDisp }}">{{ number_format($disponibilidad, 1) }}%</p>
            <p class="text-xs text-gray-400 mt-0.5">MTBF / (MTBF + MTTR)</p>
        @else
            <p class="text-xl font-bold text-gray-300">N/A</p>
            <p class="text-xs text-gray-400 mt-0.5">datos insuficientes</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow px-5 py-4 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Frec. de fallos</p>
        @if($frecuenciaFallos !== null)
            <p class="text-2xl font-bold text-red-500">{{ number_format($frecuenciaFallos, 2) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">fallas / 1000 h operativas</p>
        @else
            <p class="text-xl font-bold text-gray-300">N/A</p>
            <p class="text-xs text-gray-400 mt-0.5">sin datos</p>
        @endif
    </div>

</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

    <div class="bg-white rounded-xl shadow px-5 py-4 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Fallas totales</p>
        <p class="text-2xl font-bold text-gray-800">{{ $numFallas }}</p>
        <p class="text-xs text-gray-400 mt-0.5">correctivos registrados</p>
    </div>

    <div class="bg-white rounded-xl shadow px-5 py-4 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Horas de paro</p>
        <p class="text-2xl font-bold {{ $horasParo >= 24 ? 'text-red-600' : ($horasParo >= 8 ? 'text-yellow-500' : 'text-gray-800') }}">
            {{ number_format($horasParo, 1) }}
        </p>
        <p class="text-xs text-gray-400 mt-0.5">horas totales parado</p>
    </div>

    <div class="bg-white rounded-xl shadow px-5 py-4 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">H. operativas</p>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($horasOperativas, 1) }}</p>
        <p class="text-xs text-gray-400 mt-0.5">en periodo analizado</p>
    </div>

    <div class="bg-white rounded-xl shadow px-5 py-4 text-center">
        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Costo repuestos</p>
        <p class="text-2xl font-bold text-green-600">₡{{ number_format($costoRepuestos, 0) }}</p>
        <p class="text-xs text-gray-400 mt-0.5">acumulado total</p>
    </div>

</div>

<h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Datos del equipo</h2>
<div class="bg-white rounded-xl shadow divide-y divide-gray-100 mb-8">
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Código</span>
        <span class="text-sm font-mono text-gray-700">{{ $activo->codigo }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Nombre</span>
        <span class="text-sm font-medium text-gray-800">{{ $activo->nombre }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Área / Proceso</span>
        <span class="text-sm text-gray-800">{{ $activo->area }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Tipo</span>
        <span class="text-sm text-gray-800">{{ $activo->tipo }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Estado</span>
        @if($activo->estado === 'Activo')
            <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Activo</span>
        @else
            <span class="bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">Fuera de servicio</span>
        @endif
    </div>
</div>

<a href="{{ route('activos.index') }}"
   class="text-sm text-gray-500 hover:text-gray-700 transition">← Volver al listado</a>
@endsection