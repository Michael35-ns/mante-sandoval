<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\OrdenTrabajo;
use App\Models\Personal;
use App\Models\Repuesto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrdenTrabajoController extends Controller
{
    public function index(): View
    {
        $ordenes = OrdenTrabajo::with(['activo', 'personal'])->latest('fecha_inicio')->get();
        return view('mantenimiento.index', compact('ordenes'));
    }

    public function create(): View
    {
        $activos   = Activo::where('estado', 'Activo')->get();
        $personals = Personal::orderBy('nombre')->get();
        $repuestos = Repuesto::orderBy('descripcion')->get();
        return view('mantenimiento.create', compact('activos', 'personals', 'repuestos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'activo_id'   => 'required|exists:activos,id',
            'tipo'        => 'required|in:Correctivo,Preventivo,Predictivo',
            'fecha_inicio'=> 'required|date',
            'fecha_fin'   => 'required|date|after:fecha_inicio',
            'descripcion' => 'nullable|string',
            'personal'    => 'nullable|array',
            'personal.*'  => 'exists:personal,id',
            'repuestos'   => 'nullable|array',
            'repuestos.*.repuesto_id'    => 'required|exists:repuestos,id',
            'repuestos.*.cantidad'       => 'required|integer|min:1',
            'repuestos.*.costo_unitario' => 'required|numeric|min:0',
        ]);

        $orden = OrdenTrabajo::create($request->only(['activo_id', 'tipo', 'fecha_inicio', 'fecha_fin', 'descripcion']));

        if ($request->filled('personal')) {
            $orden->personal()->sync($request->personal);
        }

        if ($request->filled('repuestos')) {
            foreach ($request->repuestos as $rep) {
                $orden->repuestos()->create([
                    'repuesto_id'    => $rep['repuesto_id'],
                    'cantidad'       => $rep['cantidad'],
                    'costo_unitario' => $rep['costo_unitario'],
                ]);
            }
        }

        return redirect()->route('mantenimiento.index')->with('success', 'Orden de trabajo registrada correctamente.');
    }

    public function show(OrdenTrabajo $mantenimiento): View
    {
        $mantenimiento->load(['activo', 'personal', 'repuestos.repuesto']);
        return view('mantenimiento.show', compact('mantenimiento'));
    }

    public function edit(OrdenTrabajo $mantenimiento): View
    {
        $mantenimiento->load(['personal', 'repuestos']);
        $activos   = Activo::orderBy('nombre')->get();
        $personals = Personal::orderBy('nombre')->get();
        $repuestos = Repuesto::orderBy('descripcion')->get();
        return view('mantenimiento.edit', compact('mantenimiento', 'activos', 'personals', 'repuestos'));
    }

    public function update(Request $request, OrdenTrabajo $mantenimiento): RedirectResponse
    {
        $request->validate([
            'activo_id'   => 'required|exists:activos,id',
            'tipo'        => 'required|in:Correctivo,Preventivo,Predictivo',
            'fecha_inicio'=> 'required|date',
            'fecha_fin'   => 'required|date|after:fecha_inicio',
            'descripcion' => 'nullable|string',
            'personal'    => 'nullable|array',
            'personal.*'  => 'exists:personal,id',
            'repuestos'   => 'nullable|array',
            'repuestos.*.repuesto_id'    => 'required|exists:repuestos,id',
            'repuestos.*.cantidad'       => 'required|integer|min:1',
            'repuestos.*.costo_unitario' => 'required|numeric|min:0',
        ]);

        $mantenimiento->update($request->only(['activo_id', 'tipo', 'fecha_inicio', 'fecha_fin', 'descripcion']));

        $mantenimiento->personal()->sync($request->personal ?? []);

        $mantenimiento->repuestos()->delete();
        if ($request->filled('repuestos')) {
            foreach ($request->repuestos as $rep) {
                $mantenimiento->repuestos()->create([
                    'repuesto_id'    => $rep['repuesto_id'],
                    'cantidad'       => $rep['cantidad'],
                    'costo_unitario' => $rep['costo_unitario'],
                ]);
            }
        }

        return redirect()->route('mantenimiento.index')->with('success', 'Orden de trabajo actualizada.');
    }

    public function destroy(OrdenTrabajo $mantenimiento): RedirectResponse
    {
        $mantenimiento->delete();
        return redirect()->route('mantenimiento.index')->with('success', 'Orden de trabajo eliminada.');
    }
}