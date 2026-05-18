<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repuestos', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('codigo', 30)->unique();
            $table->string('descripcion', 200);
            $table->decimal('costo_unitario', 12, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repuestos');
    }
};