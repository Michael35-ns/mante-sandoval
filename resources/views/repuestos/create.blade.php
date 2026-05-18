@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Agregar Repuesto</h1>
    <p class="text-sm text-gray-500 mt-1">Registrá un nuevo repuesto en el catálogo.</p>
</div>

<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('repuestos.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                <input type="text" name="codigo" value="{{ old('codigo') }}" maxlength="30" required
                       placeholder="Ej: REP-001"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('codigo') border-red-400 @enderror">
                @error('codigo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <input type="text" name="descripcion" value="{{ old('descripcion') }}" maxlength="200" required
                       placeholder="Ej: Rodamiento 6205-2RS"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion') border-red-400 @enderror">
                @error('descripcion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Costo unitario (₡)</label>
                <input type="number" name="costo_unitario" value="{{ old('costo_unitario') }}" min="0" step="0.01" required
                       placeholder="0.00"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('costo_unitario') border-red-400 @enderror">
                @error('costo_unitario') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2 rounded-lg transition">
                    Guardar repuesto
                </button>
                <a href="{{ route('repuestos.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection