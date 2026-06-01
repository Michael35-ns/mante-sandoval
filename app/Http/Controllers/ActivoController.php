<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ActivoController extends Controller
{
    public function index(Request $request): View
    {
        $activos = Activo::query()
            ->when($request->buscar, fn($q, $v) =>
                $q->where('nombre', 'like', "%{$v}%")
                  ->orWhere('codigo', 'like', "%{$v}%")
            )
            ->when($request->area,   fn($q, $v) => $q->where('area',   'like', "%{$v}%"))
            ->when($request->tipo,   fn($q, $v) => $q->where('tipo',   $v))
            ->when($request->estado, fn($q, $v) => $q->where('estado', $v))
            ->get();

        return view('activos.index', compact('activos'));
    }

    public function create(): View
    {
        return view('activos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'codigo' => 'required|string|max:20|unique:activos,codigo',
            'nombre' => 'required|string|max:100',
            'area'   => 'required|string|max:100',
            'tipo'   => 'required|in:Motor,Bomba,Compresor,Ventilador,Conveyor,Transformador,Generador,Otro',
            'estado' => 'required|in:Activo,Fuera de servicio',
        ]);

        Activo::create($request->only(['codigo', 'nombre', 'area', 'tipo', 'estado']));

        return redirect()->route('activos.index')->with('success', 'Activo registrado correctamente.');
    }

    public function show(Activo $activo): View
    {
        $activo->load([
            'ordenesTrabajo.repuestos',
            'paros',
        ]);

        // ── Órdenes correctivas (fallas) ──────────────────────────────
        $correctivas = $activo->ordenesTrabajo->where('tipo', 'Correctivo');
        $numFallas   = $correctivas->count();

        // ── MTTR: promedio de horas de intervención correctiva ─────────
        $mttr = $numFallas > 0
            ? $correctivas->avg('horas_intervencion')
            : null;

        // ── Periodo de análisis ────────────────────────────────────────
        // Desde el primer evento (OT o paro) hasta el último
        $todasFechasInicio = $activo->ordenesTrabajo->pluck('fecha_inicio')
            ->merge($activo->paros->pluck('fecha_inicio'))
            ->filter()
            ->sort();

        $todasFechasFin = $activo->ordenesTrabajo->pluck('fecha_fin')
            ->merge($activo->paros->pluck('fecha_fin'))
            ->filter()
            ->sort();

        $periodoHoras = 0;
        if ($todasFechasInicio->isNotEmpty() && $todasFechasFin->isNotEmpty()) {
            $inicio = \Carbon\Carbon::parse($todasFechasInicio->first());
            $fin    = \Carbon\Carbon::parse($todasFechasFin->last());
            $periodoHoras = max(0, $inicio->diffInMinutes($fin) / 60);
        }

        // ── Horas totales de paro ──────────────────────────────────────
        $horasParo = $activo->paros->sum('horas_paro');

        // ── Horas operativas = periodo - horas de paro ─────────────────
        $horasOperativas = max(0, $periodoHoras - $horasParo);

        // ── MTBF: horas operativas / número de fallas ─────────────────
        $mtbf = ($numFallas > 0 && $horasOperativas > 0)
            ? $horasOperativas / $numFallas
            : null;

        // ── Disponibilidad = MTBF / (MTBF + MTTR) * 100 ───────────────
        $disponibilidad = ($mtbf !== null && $mttr !== null && ($mtbf + $mttr) > 0)
            ? ($mtbf / ($mtbf + $mttr)) * 100
            : null;

        // ── Frecuencia de fallos (fallas por cada 1000 h operativas) ───
        $frecuenciaFallos = ($numFallas > 0 && $horasOperativas > 0)
            ? ($numFallas / $horasOperativas) * 1000
            : null;

        // ── Costo de mantenimiento ─────────────────────────────────────
        $costoRepuestos = $activo->ordenesTrabajo
            ->flatMap(fn($ot) => $ot->repuestos)
            ->sum('costo_total');

        return view('activos.show', compact(
            'activo',
            'numFallas',
            'mttr',
            'mtbf',
            'disponibilidad',
            'frecuenciaFallos',
            'horasParo',
            'horasOperativas',
            'periodoHoras',
            'costoRepuestos',
        ));
    }

    public function edit(Activo $activo): View
    {
        return view('activos.edit', compact('activo'));
    }

    public function update(Request $request, Activo $activo): RedirectResponse
    {
        $request->validate([
            'codigo' => 'required|string|max:20|unique:activos,codigo,' . $activo->id,
            'nombre' => 'required|string|max:100',
            'area'   => 'required|string|max:100',
            'tipo'   => 'required|in:Motor,Bomba,Compresor,Ventilador,Conveyor,Transformador,Generador,Otro',
            'estado' => 'required|in:Activo,Fuera de servicio',
        ]);

        $activo->update($request->only(['codigo', 'nombre', 'area', 'tipo', 'estado']));

        return redirect()->route('activos.index')->with('success', 'Activo actualizado correctamente.');
    }

    public function destroy(Activo $activo): RedirectResponse
    {
        $activo->delete();
        return redirect()->route('activos.index')->with('success', 'Activo eliminado.');
    }
}