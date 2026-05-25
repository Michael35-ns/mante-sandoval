<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('activos')->insert([
            ['codigo' => 'EQ-001', 'nombre' => 'Bomba Centrífuga B-01',      'area' => 'Producción',  'tipo' => 'Bomba',       'estado' => 'Activo'],
            ['codigo' => 'EQ-002', 'nombre' => 'Compresor de Aire C-01',     'area' => 'Utilidades',  'tipo' => 'Compresor',   'estado' => 'Activo'],
            ['codigo' => 'EQ-003', 'nombre' => 'Motor Eléctrico M-05',       'area' => 'Ensamblaje',  'tipo' => 'Motor',       'estado' => 'Activo'],
            ['codigo' => 'EQ-004', 'nombre' => 'Ventilador Industrial V-02', 'area' => 'HVAC',        'tipo' => 'Ventilador',  'estado' => 'Fuera de servicio'],
            ['codigo' => 'EQ-005', 'nombre' => 'Bomba de Vacío B-02',        'area' => 'Laboratorio', 'tipo' => 'Bomba',       'estado' => 'Activo'],
        ]);
    }
}