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
        Schema::create('destinos_intermedios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('localidadIntermedia');
            $table->unsignedBigInteger('idRuta')->index('destinos_intermedios_idruta_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinos_intermedios');
    }
};
