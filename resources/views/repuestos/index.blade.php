@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Repuestos</h1>
    <a href="{{ route('repuestos.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
        + Agregar Repuesto
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
                <th class="px-6 py-3">Código</th>
                <th class="px-6 py-3">Descripción</th>
                <th class="px-6 py-3 text-right">Costo unitario</th>
                <th class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($repuestos as $repuesto)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-mono text-gray-500 text-xs">{{ $repuesto->codigo }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $repuesto->descripcion }}</td>
                    <td class="px-6 py-4 text-right font-semibold text-gray-700">
                        ₡{{ number_format($repuesto->costo_unitario, 2) }}
                    </td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <a href="{{ route('repuestos.show', $repuesto) }}"
                           class="text-blue-600 hover:underline text-xs font-medium">Ver</a>
                        <a href="{{ route('repuestos.edit', $repuesto) }}"
                           class="text-yellow-600 hover:underline text-xs font-medium">Editar</a>
                        <form action="{{ route('repuestos.destroy', $repuesto) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este repuesto?')">
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
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 text-sm">
                        No hay repuestos registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection