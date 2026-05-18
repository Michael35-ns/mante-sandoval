<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_trabajo', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('activo_id');
            $table->enum('tipo', ['Correctivo','Preventivo','Predictivo']);
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->text('descripcion')->nullable();
            $table->foreign('activo_id')->references('id')->on('activos')->cascadeOnDelete();
        });

        DB::statement('ALTER TABLE ordenes_trabajo ADD COLUMN horas_intervencion DECIMAL(8,2) GENERATED ALWAYS AS (TIMESTAMPDIFF(SECOND, fecha_inicio, fecha_fin) / 3600.0) STORED');
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo');
    }
};