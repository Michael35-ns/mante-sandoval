<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('codigo', 20)->unique();
            $table->string('nombre', 100);
            $table->string('area', 100);
            $table->enum('tipo', ['Motor','Bomba','Compresor','Ventilador','Conveyor','Transformador','Generador','Banda','Otro'])->default('Otro');
            $table->enum('estado', ['Activo','Fuera de servicio'])->default('Activo');
            $table->timestamp('fecha_registro')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activos');
    }
};