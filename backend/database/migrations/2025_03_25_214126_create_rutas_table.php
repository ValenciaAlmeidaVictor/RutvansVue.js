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
        Schema::create('rutas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tarifa');
            $table->unsignedBigInteger('idLocalidadOrigen')->index('rutas_idlocalidadorigen_foreign');
            $table->unsignedBigInteger('idLocalidadDestino')->index('rutas_idlocalidaddestino_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutas');
    }
};
