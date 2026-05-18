@extends('layouts.app')

@section('content')
@php
    $colores = ['Correctivo' => 'red', 'Preventivo' => 'blue', 'Predictivo' => 'yellow'];
    $c = $colores[$mantenimiento->tipo] ?? 'gray';
@endphp

<div class="flex items-start justify-between mb-6">
    <div>
        <div class="flex items-center gap-3 mb-1">
            <h1 class="text-2xl font-bold text-gray-800">Orden #{{ $mantenimiento->id }}</h1>
            <span class="bg-{{ $c }}-100 text-{{ $c }}-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                {{ $mantenimiento->tipo }}
            </span>
        </div>
        <p class="text-sm text-gray-500">{{ $mantenimiento->activo->nombre }} — {{ $mantenimiento->activo->codigo }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('mantenimiento.edit', $mantenimiento) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            Editar
        </a>
        <form action="{{ route('mantenimiento.destroy', $mantenimiento) }}" method="POST"
              onsubmit="return confirm('¿Eliminar esta orden?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                Eliminar
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center">
        <p class="text-2xl font-bold text-blue-600">{{ number_format($mantenimiento->horas_intervencion, 2) }}</p>
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Horas de intervención</p>
    </div>
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center">
        <p class="text-2xl font-bold text-gray-800">{{ $mantenimiento->personal->count() }}</p>
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Técnicos asignados</p>
    </div>
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center">
        <p class="text-2xl font-bold text-green-600">
            ₡{{ number_format($mantenimiento->repuestos->sum('costo_total'), 2) }}
        </p>
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Costo en repuestos</p>
    </div>
</div>

{{-- Detalle --}}
<div class="bg-white rounded-xl shadow divide-y divide-gray-100 mb-6">
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Equipo</span>
        <span class="text-sm font-medium text-gray-800">{{ $mantenimiento->activo->nombre }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Tipo</span>
        <span class="text-sm font-medium text-gray-800">{{ $mantenimiento->tipo }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Fecha inicio</span>
        <span class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($mantenimiento->fecha_inicio)->format('d/m/Y H:i') }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Fecha fin</span>
        <span class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($mantenimiento->fecha_fin)->format('d/m/Y H:i') }}</span>
    </div>
    <div class="px-6 py-4">
        <span class="text-sm text-gray-500 block mb-1">Descripción</span>
        <p class="text-sm text-gray-800">{{ $mantenimiento->descripcion ?: '—' }}</p>
    </div>
</div>

{{-- Personal --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Personal involucrado</h2>
    @if($mantenimiento->personal->isEmpty())
        <p class="text-sm text-gray-400">Sin personal asignado.</p>
    @else
        <div class="flex flex-wrap gap-2">
            @foreach($mantenimiento->personal as $p)
                <span class="bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1.5 rounded-full">
                    {{ $p->nombre }}
                    @if($p->cargo) <span class="text-blue-400">· {{ $p->cargo }}</span> @endif
                </span>
            @endforeach
        </div>
    @endif
</div>

{{-- Repuestos --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Repuestos utilizados</h2>
    @if($mantenimiento->repuestos->isEmpty())
        <p class="text-sm text-gray-400">Sin repuestos registrados.</p>
    @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-2 text-left">Código</th>
                    <th class="px-4 py-2 text-left">Descripción</th>
                    <th class="px-4 py-2 text-right">Cantidad</th>
                    <th class="px-4 py-2 text-right">C. Unitario</th>
                    <th class="px-4 py-2 text-right">C. Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($mantenimiento->repuestos as $r)
                    <tr>
                        <td class="px-4 py-3 font-mono text-gray-500 text-xs">{{ $r->repuesto->codigo }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $r->repuesto->descripcion }}</td>
                        <td class="px-4 py-3 text-right text-gray-700">{{ $r->cantidad }}</td>
                        <td class="px-4 py-3 text-right text-gray-700">₡{{ number_format($r->costo_unitario, 2) }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">₡{{ number_format($r->costo_total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t border-gray-200">
                <tr>
                    <td colspan="4" class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Total</td>
                    <td class="px-4 py-3 text-right font-bold text-green-600">
                        ₡{{ number_format($mantenimiento->repuestos->sum('costo_total'), 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif
</div>

<a href="{{ route('mantenimiento.index') }}"
   class="text-sm text-gray-500 hover:text-gray-700 transition">← Volver al listado</a>
@endsection