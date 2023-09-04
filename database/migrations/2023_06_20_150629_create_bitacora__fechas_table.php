<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bitacora__fechas', function (Blueprint $table) {
            $table->id();
            $table->integer('siniestro_id');
            $table->integer('usuario_actualiza_id');
            $table->string('fecha_anterior');
            $table->string('fecha_nueva');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora__fechas');
    }
};
