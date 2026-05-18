@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Editar Paro #{{ $paro->id }}</h1>
    <p class="text-sm text-gray-500 mt-1">Modificá los datos del paro de <span class="font-medium text-gray-700">{{ $paro->activo->nombre }}</span>.</p>
</div>

<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('paros.update', $paro) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Equipo afectado</label>
                <select name="activo_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('activo_id') border-red-400 @enderror">
                    <option value="">— Seleccionar —</option>
                    @foreach($activos as $activo)
                        <option value="{{ $activo->id }}"
                            {{ old('activo_id', $paro->activo_id) == $activo->id ? 'selected' : '' }}>
                            {{ $activo->nombre }} ({{ $activo->codigo }})
                        </option>
                    @endforeach
                </select>
                @error('activo_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Inicio del paro</label>
                    <input type="datetime-local" name="fecha_inicio" required
                           value="{{ old('fecha_inicio', \Carbon\Carbon::parse($paro->fecha_inicio)->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_inicio') border-red-400 @enderror">
                    @error('fecha_inicio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fin del paro</label>
                    <input type="datetime-local" name="fecha_fin" required
                           value="{{ old('fecha_fin', \Carbon\Carbon::parse($paro->fecha_fin)->format('Y-m-d\TH:i')) }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_fin') border-red-400 @enderror">
                    @error('fecha_fin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div id="preview-horas" class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-3 text-sm text-blue-700">
                Duración calculada: <span id="horas-valor" class="font-bold"></span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Causa del paro</label>
                <input type="text" name="causa" maxlength="255"
                       value="{{ old('causa', $paro->causa) }}"
                       placeholder="Ej: Falla mecánica, mantenimiento preventivo..."
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('causa') border-red-400 @enderror">
                @error('causa') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-6 py-2 rounded-lg transition">
                    Actualizar
                </button>
                <a href="{{ route('paros.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 transition">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
const inicio   = document.querySelector('[name="fecha_inicio"]');
const fin      = document.querySelector('[name="fecha_fin"]');
const horasVal = document.getElementById('horas-valor');

function calcularHoras() {
    if (!inicio.value || !fin.value) return;
    const diff = (new Date(fin.value) - new Date(inicio.value)) / 3600000;
    if (diff <= 0) { horasVal.textContent = 'Fechas inválidas'; return; }
    const h = Math.floor(diff);
    const m = Math.round((diff - h) * 60);
    horasVal.textContent = `${h}h ${m}m (${diff.toFixed(2)} h)`;
}

inicio.addEventListener('change', calcularHoras);
fin.addEventListener('change', calcularHoras);
document.addEventListener('DOMContentLoaded', calcularHoras);
</script>
@endsection