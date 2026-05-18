@extends('layouts.app')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Paro #{{ $paro->id }}</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $paro->activo->nombre }} — {{ $paro->activo->codigo }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('paros.edit', $paro) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            Editar
        </a>
        <form action="{{ route('paros.destroy', $paro) }}" method="POST"
              onsubmit="return confirm('¿Eliminar este paro?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                Eliminar
            </button>
        </form>
    </div>
</div>

@php $hrs = $paro->horas_paro; @endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center">
        <p class="text-2xl font-bold {{ $hrs >= 8 ? 'text-red-600' : ($hrs >= 4 ? 'text-yellow-500' : 'text-blue-600') }}">
            {{ number_format($hrs, 2) }}
        </p>
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Horas de paro</p>
    </div>
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center">
        <p class="text-2xl font-bold text-gray-800">
            {{ \Carbon\Carbon::parse($paro->fecha_inicio)->format('d/m/Y') }}
        </p>
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Fecha de inicio</p>
    </div>
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center">
        <p class="text-2xl font-bold text-gray-800">
            {{ \Carbon\Carbon::parse($paro->fecha_fin)->format('d/m/Y') }}
        </p>
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Fecha de fin</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow divide-y divide-gray-100 mb-6">
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Equipo afectado</span>
        <span class="text-sm font-medium text-gray-800">{{ $paro->activo->nombre }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Código</span>
        <span class="text-sm font-mono text-gray-600">{{ $paro->activo->codigo }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Inicio del paro</span>
        <span class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($paro->fecha_inicio)->format('d/m/Y H:i') }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Fin del paro</span>
        <span class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($paro->fecha_fin)->format('d/m/Y H:i') }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Duración total</span>
        <span class="text-sm font-semibold {{ $hrs >= 8 ? 'text-red-600' : ($hrs >= 4 ? 'text-yellow-600' : 'text-gray-800') }}">
            {{ number_format($hrs, 2) }} horas
        </span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Causa</span>
        <span class="text-sm text-gray-800">{{ $paro->causa ?: '—' }}</span>
    </div>
</div>

<a href="{{ route('paros.index') }}"
   class="text-sm text-gray-500 hover:text-gray-700 transition">← Volver al listado</a>
@endsection