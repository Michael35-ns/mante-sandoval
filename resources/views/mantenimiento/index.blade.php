@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Órdenes de Trabajo</h1>
    <a href="{{ route('mantenimiento.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
        + Nueva Orden
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 text-sm rounded-lg px-4 py-3 mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
            <tr>
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">Equipo</th>
                <th class="px-6 py-3">Tipo</th>
                <th class="px-6 py-3">Inicio</th>
                <th class="px-6 py-3">Fin</th>
                <th class="px-6 py-3">Hrs</th>
                <th class="px-6 py-3">Personal</th>
                <th class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($ordenes as $orden)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">{{ $orden->id }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $orden->activo->nombre }}</td>
                    <td class="px-6 py-4">
                        @php
                            $colores = ['Correctivo' => 'red', 'Preventivo' => 'blue', 'Predictivo' => 'yellow'];
                            $c = $colores[$orden->tipo] ?? 'gray';
                        @endphp
                        <span class="bg-{{ $c }}-100 text-{{ $c }}-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                            {{ $orden->tipo }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-xs">{{ \Carbon\Carbon::parse($orden->fecha_inicio)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-gray-600 text-xs">{{ \Carbon\Carbon::parse($orden->fecha_fin)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-gray-700 font-mono">{{ number_format($orden->horas_intervencion, 1) }}</td>
                    <td class="px-6 py-4 text-gray-600 text-xs">
                        {{ $orden->personal->pluck('nombre')->join(', ') ?: '—' }}
                    </td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <a href="{{ route('mantenimiento.show', $orden) }}"
                           class="text-blue-600 hover:underline text-xs font-medium">Ver</a>
                        <a href="{{ route('mantenimiento.edit', $orden) }}"
                           class="text-yellow-600 hover:underline text-xs font-medium">Editar</a>
                        <form action="{{ route('mantenimiento.destroy', $orden) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar esta orden?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs font-medium">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-gray-400 text-sm">
                        No hay órdenes de trabajo registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection