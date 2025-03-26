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
        Schema::create('ruta_unidad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fecha');
            $table->unsignedBigInteger('idUnidad')->index('ruta_unidad_idunidad_foreign');
            $table->unsignedBigInteger('idRuta')->index('ruta_unidad_idruta_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruta_unidad');
    }
};
