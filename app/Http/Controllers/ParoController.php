<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\Paro;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ParoController extends Controller
{
    public function index(): View
    {
        $paros = Paro::with('activo')->latest('fecha_inicio')->get();
        return view('paros.index', compact('paros'));
    }

    public function create(): View
    {
        $activos = Activo::orderBy('nombre')->get();
        return view('paros.create', compact('activos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'activo_id'   => 'required|exists:activos,id',
            'fecha_inicio'=> 'required|date',
            'fecha_fin'   => 'required|date|after:fecha_inicio',
            'causa'       => 'nullable|string|max:255',
        ]);

        Paro::create($request->only(['activo_id', 'fecha_inicio', 'fecha_fin', 'causa']));

        return redirect()->route('paros.index')->with('success', 'Paro registrado correctamente.');
    }

    public function show(Paro $paro): View
    {
        $paro->load('activo');
        return view('paros.show', compact('paro'));
    }

    public function edit(Paro $paro): View
    {
        $activos = Activo::orderBy('nombre')->get();
        return view('paros.edit', compact('paro', 'activos'));
    }

    public function update(Request $request, Paro $paro): RedirectResponse
    {
        $request->validate([
            'activo_id'   => 'required|exists:activos,id',
            'fecha_inicio'=> 'required|date',
            'fecha_fin'   => 'required|date|after:fecha_inicio',
            'causa'       => 'nullable|string|max:255',
        ]);

        $paro->update($request->only(['activo_id', 'fecha_inicio', 'fecha_fin', 'causa']));

        return redirect()->route('paros.index')->with('success', 'Paro actualizado correctamente.');
    }

    public function destroy(Paro $paro): RedirectResponse
    {
        $paro->delete();
        return redirect()->route('paros.index')->with('success', 'Paro eliminado.');
    }
}