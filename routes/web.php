<?php

use App\Http\Controllers\ActivoController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\ParoController;
use App\Http\Controllers\RepuestoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('activos', ActivoController::class);
Route::resource('mantenimiento', OrdenTrabajoController::class);
Route::resource('paros',ParoController::class);
Route::resource('repuestos', RepuestoController::class);