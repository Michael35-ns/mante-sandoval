@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Editar Orden de Trabajo</h1>
    <p class="text-sm text-gray-500 mt-1">Modificá los datos de la orden <span class="font-medium text-gray-700">#{{ $mantenimiento->id }}</span>.</p>
</div>

<form action="{{ route('mantenimiento.update', $mantenimiento) }}" method="POST" class="space-y-6">
@csrf
@method('PUT')

    {{-- Datos básicos --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Datos generales</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Equipo</label>
                <select name="activo_id" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('activo_id') border-red-400 @enderror">
                    <option value="">— Seleccionar —</option>
                    @foreach($activos as $activo)
                        <option value="{{ $activo->id }}"
                            {{ old('activo_id', $mantenimiento->activo_id) == $activo->id ? 'selected' : '' }}>
                            {{ $activo->nombre }} ({{ $activo->codigo }})
                        </option>
                    @endforeach
                </select>
                @error('activo_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de mantenimiento</label>
                <select name="tipo" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipo') border-red-400 @enderror">
                    @foreach(['Correctivo','Preventivo','Predictivo'] as $tipo)
                        <option value="{{ $tipo }}"
                            {{ old('tipo', $mantenimiento->tipo) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                    @endforeach
                </select>
                @error('tipo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha y hora de inicio</label>
                <input type="datetime-local" name="fecha_inicio" required
                       value="{{ old('fecha_inicio', \Carbon\Carbon::parse($mantenimiento->fecha_inicio)->format('Y-m-d\TH:i')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_inicio') border-red-400 @enderror">
                @error('fecha_inicio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha y hora de fin</label>
                <input type="datetime-local" name="fecha_fin" required
                       value="{{ old('fecha_fin', \Carbon\Carbon::parse($mantenimiento->fecha_fin)->format('Y-m-d\TH:i')) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha_fin') border-red-400 @enderror">
                @error('fecha_fin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción de falla / actividad</label>
                <textarea name="descripcion" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Describa la falla o actividad realizada...">{{ old('descripcion', $mantenimiento->descripcion) }}</textarea>
            </div>

        </div>
    </div>

    {{-- Personal --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Personal involucrado</h2>
        @php $personalActual = $mantenimiento->personal->pluck('id')->toArray(); @endphp
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($personals as $p)
                <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox" name="personal[]" value="{{ $p->id }}"
                           {{ in_array($p->id, old('personal', $personalActual)) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span>{{ $p->nombre }}</span>
                    <span class="text-xs text-gray-400">{{ $p->cargo }}</span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Repuestos --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Repuestos utilizados</h2>
            <button type="button" onclick="agregarRepuesto()"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                + Agregar repuesto
            </button>
        </div>

        <div id="repuestos-container" class="space-y-3"></div>
        <p id="repuestos-vacio" class="text-sm text-gray-400 py-2 hidden">No hay repuestos agregados.</p>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-6 py-2 rounded-lg transition">
            Actualizar orden
        </button>
        <a href="{{ route('mantenimiento.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 transition">Cancelar</a>
    </div>

</form>

<script>
const repuestosData = @json($repuestos);
const repuestosActuales = @json($mantenimiento->repuestos);
let contador = 0;

function agregarRepuesto(repuesto_id = '', cantidad = 1, costo_unitario = '') {
    const contenedor = document.getElementById('repuestos-container');
    document.getElementById('repuestos-vacio').classList.add('hidden');

    const fila = document.createElement('div');
    fila.className = 'grid grid-cols-12 gap-2 items-end';
    fila.id = `fila-rep-${contador}`;

    const options = repuestosData.map(r =>
        `<option value="${r.id}" data-costo="${r.costo_unitario}" ${r.id == repuesto_id ? 'selected' : ''}>${r.descripcion} (${r.codigo})</option>`
    ).join('');

    fila.innerHTML = `
        <div class="col-span-5">
            ${contador === 0 ? '<label class="block text-xs text-gray-500 mb-1">Repuesto</label>' : ''}
            <select name="repuestos[${contador}][repuesto_id]"
                    onchange="autocompletarCosto(this, ${contador})"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">— Seleccionar —</option>
                ${options}
            </select>
        </div>
        <div class="col-span-2">
            ${contador === 0 ? '<label class="block text-xs text-gray-500 mb-1">Cantidad</label>' : ''}
            <input type="number" name="repuestos[${contador}][cantidad]" value="${cantidad}" min="1" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="col-span-3">
            ${contador === 0 ? '<label class="block text-xs text-gray-500 mb-1">Costo unitario</label>' : ''}
            <input type="number" name="repuestos[${contador}][costo_unitario]" id="costo-${contador}"
                   value="${costo_unitario}" min="0" step="0.01" required
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div class="col-span-2">
            <button type="button" onclick="eliminarFila('fila-rep-${contador}')"
                    class="w-full bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium py-2 rounded-lg transition">
                Quitar
            </button>
        </div>
    `;

    contenedor.appendChild(fila);
    contador++;
}

function autocompletarCosto(select, idx) {
    const opt = select.options[select.selectedIndex];
    document.getElementById(`costo-${idx}`).value = opt.dataset.costo || '';
}

function eliminarFila(id) {
    document.getElementById(id).remove();
    if (document.getElementById('repuestos-container').children.length === 0) {
        document.getElementById('repuestos-vacio').classList.remove('hidden');
    }
}

// Precargar repuestos existentes
document.addEventListener('DOMContentLoaded', () => {
    if (repuestosActuales.length === 0) {
        document.getElementById('repuestos-vacio').classList.remove('hidden');
    }
    repuestosActuales.forEach(r => agregarRepuesto(r.repuesto_id, r.cantidad, r.costo_unitario));
});
</script>
@endsection