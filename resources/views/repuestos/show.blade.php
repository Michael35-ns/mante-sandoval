@extends('layouts.app')

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">{{ $repuesto->descripcion }}</h1>
        <p class="text-sm text-gray-500 font-mono mt-1">{{ $repuesto->codigo }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('repuestos.edit', $repuesto) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            Editar
        </a>
        <form action="{{ route('repuestos.destroy', $repuesto) }}" method="POST"
              onsubmit="return confirm('¿Eliminar este repuesto?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                Eliminar
            </button>
        </form>
    </div>
</div>

@php
    $totalUnidades = $repuesto->usos->sum('cantidad');
    $totalCosto    = $repuesto->usos->sum('costo_total');
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center">
        <p class="text-2xl font-bold text-blue-600">₡{{ number_format($repuesto->costo_unitario, 2) }}</p>
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Costo unitario</p>
    </div>
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center">
        <p class="text-2xl font-bold text-gray-800">{{ $totalUnidades }}</p>
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Unidades utilizadas</p>
    </div>
    <div class="bg-white rounded-xl shadow px-6 py-4 text-center">
        <p class="text-2xl font-bold text-green-600">₡{{ number_format($totalCosto, 2) }}</p>
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Costo total acumulado</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow divide-y divide-gray-100 mb-6">
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Código</span>
        <span class="text-sm font-mono text-gray-700">{{ $repuesto->codigo }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Descripción</span>
        <span class="text-sm font-medium text-gray-800">{{ $repuesto->descripcion }}</span>
    </div>
    <div class="flex justify-between px-6 py-4">
        <span class="text-sm text-gray-500">Costo unitario</span>
        <span class="text-sm font-semibold text-gray-800">₡{{ number_format($repuesto->costo_unitario, 2) }}</span>
    </div>
</div>

{{-- Historial de uso --}}
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Historial de uso</h2>

    @if($repuesto->usos->isEmpty())
        <p class="text-sm text-gray-400">Este repuesto no ha sido utilizado en ninguna orden de trabajo.</p>
    @else
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-2 text-left">Orden #</th>
                    <th class="px-4 py-2 text-left">Equipo</th>
                    <th class="px-4 py-2 text-left">Tipo</th>
                    <th class="px-4 py-2 text-left">Fecha</th>
                    <th class="px-4 py-2 text-right">Cantidad</th>
                    <th class="px-4 py-2 text-right">Costo total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($repuesto->usos as $uso)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-mono text-gray-500 text-xs">
                            <a href="{{ route('mantenimiento.show', $uso->orden) }}"
                               class="text-blue-600 hover:underline">#{{ $uso->orden->id }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ $uso->orden->activo->nombre }}</td>
                        <td class="px-4 py-3">
                            @php $c = ['Correctivo'=>'red','Preventivo'=>'blue','Predictivo'=>'yellow'][$uso->orden->tipo] ?? 'gray'; @endphp
                            <span class="bg-{{ $c }}-100 text-{{ $c }}-700 text-xs font-semibold px-2 py-0.5 rounded-full">
                                {{ $uso->orden->tipo }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-600 text-xs">
                            {{ \Carbon\Carbon::parse($uso->orden->fecha_inicio)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-right text-gray-700">{{ $uso->cantidad }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">
                            ₡{{ number_format($uso->costo_total, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t border-gray-200">
                <tr>
                    <td colspan="4" class="px-4 py-3 text-right text-sm font-semibold text-gray-600">Total</td>
                    <td class="px-4 py-3 text-right font-bold text-gray-800">{{ $totalUnidades }}</td>
                    <td class="px-4 py-3 text-right font-bold text-green-600">₡{{ number_format($totalCosto, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    @endif
</div>

<a href="{{ route('repuestos.index') }}"
   class="text-sm text-gray-500 hover:text-gray-700 transition">← Volver al listado</a>
@endsection