<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paros', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('activo_id');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->string('causa', 255)->nullable();
            $table->foreign('activo_id')->references('id')->on('activos')->cascadeOnDelete();
        });

        DB::statement('ALTER TABLE paros ADD COLUMN horas_paro DECIMAL(8,2) GENERATED ALWAYS AS (TIMESTAMPDIFF(SECOND, fecha_inicio, fecha_fin) / 3600.0) STORED');
    }

    public function down(): void
    {
        Schema::dropIfExists('paros');
    }
};