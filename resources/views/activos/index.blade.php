@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Activos</h1>
    <a href="{{ route('activos.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
        + Agregar Activo
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 text-sm rounded-lg px-4 py-3 mb-6">
        {{ session('success') }}
    </div>
@endif

{{-- Búsqueda y filtros --}}
<form method="GET" action="{{ route('activos.index') }}" class="bg-white rounded-xl shadow p-4 mb-4 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[160px]">
        <label class="block text-xs text-gray-500 mb-1">Buscar</label>
        <input type="text" name="buscar" value="{{ request('buscar') }}"
               placeholder="Nombre o código..."
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="min-w-[140px]">
        <label class="block text-xs text-gray-500 mb-1">Área</label>
        <input type="text" name="area" value="{{ request('area') }}"
               placeholder="Ej: Producción"
               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
    <div class="min-w-[130px]">
        <label class="block text-xs text-gray-500 mb-1">Tipo</label>
        <select name="tipo" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Todos</option>
            @foreach(['Motor','Bomba','Compresor','Ventilador','Conveyor','Transformador','Generador','Otro'] as $t)
                <option value="{{ $t }}" {{ request('tipo') == $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>
    <div class="min-w-[130px]">
        <label class="block text-xs text-gray-500 mb-1">Estado</label>
        <select name="estado" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Todos</option>
            <option value="Activo"           {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
            <option value="Fuera de servicio" {{ request('estado') == 'Fuera de servicio' ? 'selected' : '' }}>Fuera de servicio</option>
        </select>
    </div>
    <div class="flex gap-2">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
            Buscar
        </button>
        @if(request()->hasAny(['buscar','area','tipo','estado']))
            <a href="{{ route('activos.index') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg transition">
                Limpiar
            </a>
        @endif
    </div>
</form>

@if(request()->hasAny(['buscar','area','tipo','estado']))
    <p class="text-xs text-gray-400 mb-3">{{ $activos->count() }} resultado(s) encontrado(s)</p>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
            <tr>
                <th class="px-6 py-3">Código</th>
                <th class="px-6 py-3">Nombre</th>
                <th class="px-6 py-3">Área</th>
                <th class="px-6 py-3">Tipo</th>
                <th class="px-6 py-3">Estado</th>
                <th class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($activos as $activo)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-mono text-gray-500 text-xs">{{ $activo->codigo }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $activo->nombre }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $activo->area }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $activo->tipo }}</td>
                    <td class="px-6 py-4">
                        @if($activo->estado === 'Activo')
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Activo</span>
                        @else
                            <span class="bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">Fuera de servicio</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <a href="{{ route('activos.show', $activo) }}"
                           class="text-blue-600 hover:underline text-xs font-medium">Ver</a>
                        <a href="{{ route('activos.edit', $activo) }}"
                           class="text-yellow-600 hover:underline text-xs font-medium">Editar</a>
                        <form action="{{ route('activos.destroy', $activo) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este activo?')">
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
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400 text-sm">
                        No se encontraron activos.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection