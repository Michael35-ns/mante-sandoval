<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('personal')->insert([
            ['nombre' => 'Carlos Mora',  'cargo' => 'Técnico Mecánico'],
            ['nombre' => 'Luis Díaz',    'cargo' => 'Técnico Eléctrico'],
            ['nombre' => 'Ana Rojas',    'cargo' => 'Ingeniera de Mantenimiento'],
            ['nombre' => 'Marco Solís',  'cargo' => 'Técnico Instrumentación'],
            ['nombre' => 'Diana Vargas', 'cargo' => 'Técnico Mecánico'],
        ]);
    }
}