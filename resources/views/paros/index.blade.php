@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Paros de Equipo</h1>
    <a href="{{ route('paros.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
        + Registrar Paro
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
                <th class="px-6 py-3">Inicio</th>
                <th class="px-6 py-3">Fin</th>
                <th class="px-6 py-3">Horas de paro</th>
                <th class="px-6 py-3">Causa</th>
                <th class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($paros as $paro)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-400 text-xs font-mono">{{ $paro->id }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $paro->activo->nombre }}</td>
                    <td class="px-6 py-4 text-gray-600 text-xs">{{ \Carbon\Carbon::parse($paro->fecha_inicio)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-gray-600 text-xs">{{ \Carbon\Carbon::parse($paro->fecha_fin)->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @php $hrs = $paro->horas_paro; @endphp
                        <span class="font-mono font-semibold {{ $hrs >= 8 ? 'text-red-600' : ($hrs >= 4 ? 'text-yellow-600' : 'text-gray-700') }}">
                            {{ number_format($hrs, 1) }} h
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $paro->causa ?: '—' }}</td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <a href="{{ route('paros.show', $paro) }}"
                           class="text-blue-600 hover:underline text-xs font-medium">Ver</a>
                        <a href="{{ route('paros.edit', $paro) }}"
                           class="text-yellow-600 hover:underline text-xs font-medium">Editar</a>
                        <form action="{{ route('paros.destroy', $paro) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este paro?')">
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
                    <td colspan="7" class="px-6 py-10 text-center text-gray-400 text-sm">
                        No hay paros registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection