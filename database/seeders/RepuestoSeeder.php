<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepuestoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('repuestos')->insert([
            ['codigo' => 'REP-001', 'descripcion' => 'Rodamiento 6205-2RS',          'costo_unitario' => 4500.00],
            ['codigo' => 'REP-002', 'descripcion' => 'Sello mecánico 25mm',          'costo_unitario' => 12000.00],
            ['codigo' => 'REP-003', 'descripcion' => 'Correa en V tipo B-65',        'costo_unitario' => 3200.00],
            ['codigo' => 'REP-004', 'descripcion' => 'Filtro de aceite hidráulico',  'costo_unitario' => 6800.00],
            ['codigo' => 'REP-005', 'descripcion' => 'Fusible 10A 500V',             'costo_unitario' => 850.00],
            ['codigo' => 'REP-006', 'descripcion' => 'Válvula de alivio 1/2"',       'costo_unitario' => 15500.00],
            ['codigo' => 'REP-007', 'descripcion' => 'Aceite ISO VG 68 (litro)',     'costo_unitario' => 1200.00],
            ['codigo' => 'REP-008', 'descripcion' => 'Empaque de goma 30mm',         'costo_unitario' => 950.00],
        ]);
    }
}