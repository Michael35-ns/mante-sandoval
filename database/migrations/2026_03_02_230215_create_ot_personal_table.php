<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ot_personal', function (Blueprint $table) {
            $table->unsignedInteger('ot_id');
            $table->unsignedInteger('personal_id');
            $table->primary(['ot_id', 'personal_id']);
            $table->foreign('ot_id')->references('id')->on('ordenes_trabajo')->cascadeOnDelete();
            $table->foreign('personal_id')->references('id')->on('personal')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ot_personal');
    }
};