<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ot_repuestos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('ot_id');
            $table->unsignedInteger('repuesto_id');
            $table->unsignedInteger('cantidad')->default(1);
            $table->decimal('costo_unitario', 12, 2);
            $table->foreign('ot_id')->references('id')->on('ordenes_trabajo')->cascadeOnDelete();
            $table->foreign('repuesto_id')->references('id')->on('repuestos');
        });

        DB::statement('ALTER TABLE ot_repuestos ADD COLUMN costo_total DECIMAL(12,2) GENERATED ALWAYS AS (cantidad * costo_unitario) STORED');
    }

    public function down(): void
    {
        Schema::dropIfExists('ot_repuestos');
    }
};