@extends('layouts.app')

@section('content')
<div>

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
                               class="bg-blue-600 box-border border-transparent text-white hover:bg-blue-800 text-xs leading-5 rounded font-medium px-2 py-2.5">Ver</a>
                            <a href="{{ route('activos.edit', $activo) }}"
                               class="bg-yellow-600 box-border border-transparent text-white hover:bg-yellow-800 text-xs leading-5 rounded font-medium px-2 py-2.5">Editar</a>
                            <form action="{{ route('activos.destroy', $activo) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este activo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 box-border border-transparent text-white hover:bg-red-800 text-xs leading-5 rounded font-medium px-2 py-2.5">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400 text-sm">
                            No hay activos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


@endsection