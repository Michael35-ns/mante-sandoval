<?php

namespace App\Http\Controllers;

use App\Models\Repuesto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RepuestoController extends Controller
{
    public function index(): View
    {
        $repuestos = Repuesto::orderBy('descripcion')->get();
        return view('repuestos.index', compact('repuestos'));
    }

    public function create(): View
    {
        return view('repuestos.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'codigo'         => 'required|string|max:30|unique:repuestos,codigo',
            'descripcion'    => 'required|string|max:200',
            'costo_unitario' => 'required|numeric|min:0',
        ]);

        Repuesto::create($request->only(['codigo', 'descripcion', 'costo_unitario']));

        return redirect()->route('repuestos.index')->with('success', 'Repuesto registrado correctamente.');
    }

    public function show(Repuesto $repuesto): View
    {
        $repuesto->load('usos.orden.activo');
        return view('repuestos.show', compact('repuesto'));
    }

    public function edit(Repuesto $repuesto): View
    {
        return view('repuestos.edit', compact('repuesto'));
    }

    public function update(Request $request, Repuesto $repuesto): RedirectResponse
    {
        $request->validate([
            'codigo'         => 'required|string|max:30|unique:repuestos,codigo,' . $repuesto->id,
            'descripcion'    => 'required|string|max:200',
            'costo_unitario' => 'required|numeric|min:0',
        ]);

        $repuesto->update($request->only(['codigo', 'descripcion', 'costo_unitario']));

        return redirect()->route('repuestos.index')->with('success', 'Repuesto actualizado correctamente.');
    }

    public function destroy(Repuesto $repuesto): RedirectResponse
    {
        $repuesto->delete();
        return redirect()->route('repuestos.index')->with('success', 'Repuesto eliminado.');
    }
}