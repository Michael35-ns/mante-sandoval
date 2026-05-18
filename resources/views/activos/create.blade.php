@extends('layouts.app')

@section('content')


    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Registrar Activo</h1>
        <p class="text-sm text-gray-500 mt-1">Complete los campos para agregar un nuevo equipo.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('activos.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                <input type="text" name="codigo" id="codigo"
                       value="{{ old('codigo') }}"
                       maxlength="20" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('codigo') border-red-400 @enderror">
                @error('codigo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre del equipo</label>
                <input type="text" name="nombre" id="nombre"
                       value="{{ old('nombre') }}"
                       maxlength="100" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nombre') border-red-400 @enderror">
                @error('nombre')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="area" class="block text-sm font-medium text-gray-700 mb-1">Área / Proceso</label>
                <input type="text" name="area" id="area"
                       value="{{ old('area') }}"
                       maxlength="100" required
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('area') border-red-400 @enderror">
                @error('area')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo de equipo</label>
                <select name="tipo" id="tipo" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipo') border-red-400 @enderror">
                    @foreach(['Motor','Bomba','Compresor','Ventilador','Conveyor','Transformador','Generador','Banda','Otro'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                    @endforeach
                </select>
                @error('tipo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado operativo</label>
                <select name="estado" id="estado" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('estado') border-red-400 @enderror">
                    @foreach(['Activo','Fuera de servicio'] as $estado)
                        <option value="{{ $estado }}" {{ old('estado') == $estado ? 'selected' : '' }}>{{ $estado }}</option>
                    @endforeach
                </select>
                @error('estado')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2 rounded-lg transition">
                    Guardar activo
                </button>
                <a href="{{ route('activos.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 transition">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

</div>
@endsection