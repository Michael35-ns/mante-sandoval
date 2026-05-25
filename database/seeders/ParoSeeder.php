<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('paros')->insert([
            ['activo_id' => 1, 'fecha_inicio' => '2026-01-05 07:30:00', 'fecha_fin' => '2026-01-05 12:30:00', 'causa' => 'Falla sello mecánico'],
            ['activo_id' => 2, 'fecha_inicio' => '2026-01-10 13:45:00', 'fecha_fin' => '2026-01-10 18:45:00', 'causa' => 'Vibración excesiva en rodamientos'],
            ['activo_id' => 2, 'fecha_inicio' => '2026-02-15 09:00:00', 'fecha_fin' => '2026-02-15 14:30:00', 'causa' => 'Fuga de aceite'],
            ['activo_id' => 3, 'fecha_inicio' => '2026-02-20 09:50:00', 'fecha_fin' => '2026-02-20 16:30:00', 'causa' => 'Falla eléctrica en bobinado'],
            ['activo_id' => 4, 'fecha_inicio' => '2026-01-15 12:30:00', 'fecha_fin' => '2026-01-30 08:00:00', 'causa' => 'Rotura de correa, espera de repuesto'],
            ['activo_id' => 5, 'fecha_inicio' => '2026-02-28 10:45:00', 'fecha_fin' => '2026-02-28 14:30:00', 'causa' => 'Pérdida de vacío por válvula dañada'],
        ]);
    }
}