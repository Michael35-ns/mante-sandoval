<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdenTrabajoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ordenes_trabajo')->insert([
            ['activo_id' => 1, 'tipo' => 'Correctivo',  'fecha_inicio' => '2026-01-05 08:00:00', 'fecha_fin' => '2026-01-05 12:30:00', 'descripcion' => 'Falla en sello mecánico, líquido en piso, reemplazo completo'],
            ['activo_id' => 1, 'tipo' => 'Preventivo',  'fecha_inicio' => '2026-02-01 07:00:00', 'fecha_fin' => '2026-02-01 09:00:00', 'descripcion' => 'PM programado: lubricación, ajuste de acoples y revisión general'],
            ['activo_id' => 2, 'tipo' => 'Correctivo',  'fecha_inicio' => '2026-01-10 14:00:00', 'fecha_fin' => '2026-01-10 18:45:00', 'descripcion' => 'Vibración excesiva detectada, cambio de rodamientos delanteros'],
            ['activo_id' => 2, 'tipo' => 'Correctivo',  'fecha_inicio' => '2026-02-15 09:30:00', 'fecha_fin' => '2026-02-15 14:00:00', 'descripcion' => 'Fuga de aceite en cárter, reemplazo de sellos y filtro'],
            ['activo_id' => 2, 'tipo' => 'Preventivo',  'fecha_inicio' => '2026-03-01 06:00:00', 'fecha_fin' => '2026-03-01 09:30:00', 'descripcion' => 'PM semestral: cambio de aceite, limpieza de filtros'],
            ['activo_id' => 3, 'tipo' => 'Preventivo',  'fecha_inicio' => '2026-01-20 06:00:00', 'fecha_fin' => '2026-01-20 08:30:00', 'descripcion' => 'Revisión eléctrica, medición de aislamiento y ajuste de terminales'],
            ['activo_id' => 3, 'tipo' => 'Correctivo',  'fecha_inicio' => '2026-02-20 10:00:00', 'fecha_fin' => '2026-02-20 16:00:00', 'descripcion' => 'Temperatura elevada, quemado parcial de bobinado, rebobinado'],
            ['activo_id' => 4, 'tipo' => 'Correctivo',  'fecha_inicio' => '2026-01-15 13:00:00', 'fecha_fin' => '2026-01-15 17:00:00', 'descripcion' => 'Rotura de correa, equipo parado, reemplazo de correa'],
            ['activo_id' => 5, 'tipo' => 'Preventivo',  'fecha_inicio' => '2026-01-25 07:00:00', 'fecha_fin' => '2026-01-25 08:30:00', 'descripcion' => 'Revisión de sellos, limpieza de filtro de entrada'],
            ['activo_id' => 5, 'tipo' => 'Correctivo',  'fecha_inicio' => '2026-02-28 11:00:00', 'fecha_fin' => '2026-02-28 14:30:00', 'descripcion' => 'Pérdida de vacío, válvula de alivio defectuosa, reemplazo'],
        ]);

        DB::table('ot_personal')->insert([
            ['ot_id' => 1,  'personal_id' => 1],
            ['ot_id' => 1,  'personal_id' => 3],
            ['ot_id' => 2,  'personal_id' => 1],
            ['ot_id' => 3,  'personal_id' => 1],
            ['ot_id' => 3,  'personal_id' => 4],
            ['ot_id' => 4,  'personal_id' => 1],
            ['ot_id' => 4,  'personal_id' => 5],
            ['ot_id' => 5,  'personal_id' => 1],
            ['ot_id' => 6,  'personal_id' => 2],
            ['ot_id' => 6,  'personal_id' => 3],
            ['ot_id' => 7,  'personal_id' => 2],
            ['ot_id' => 8,  'personal_id' => 5],
            ['ot_id' => 9,  'personal_id' => 5],
            ['ot_id' => 10, 'personal_id' => 1],
            ['ot_id' => 10, 'personal_id' => 4],
        ]);

        DB::table('ot_repuestos')->insert([
            ['ot_id' => 1,  'repuesto_id' => 2, 'cantidad' => 1, 'costo_unitario' => 12000.00],
            ['ot_id' => 1,  'repuesto_id' => 8, 'cantidad' => 2, 'costo_unitario' => 950.00],
            ['ot_id' => 3,  'repuesto_id' => 1, 'cantidad' => 2, 'costo_unitario' => 4500.00],
            ['ot_id' => 4,  'repuesto_id' => 2, 'cantidad' => 1, 'costo_unitario' => 12000.00],
            ['ot_id' => 4,  'repuesto_id' => 4, 'cantidad' => 1, 'costo_unitario' => 6800.00],
            ['ot_id' => 5,  'repuesto_id' => 4, 'cantidad' => 1, 'costo_unitario' => 6800.00],
            ['ot_id' => 5,  'repuesto_id' => 7, 'cantidad' => 4, 'costo_unitario' => 1200.00],
            ['ot_id' => 7,  'repuesto_id' => 1, 'cantidad' => 4, 'costo_unitario' => 4500.00],
            ['ot_id' => 8,  'repuesto_id' => 3, 'cantidad' => 2, 'costo_unitario' => 3200.00],
            ['ot_id' => 10, 'repuesto_id' => 6, 'cantidad' => 1, 'costo_unitario' => 15500.00],
        ]);
    }
}