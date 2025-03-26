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
        Schema::create('boletos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombrePasajero');
            $table->dateTime('fecha', 6);
            $table->double('total');
            $table->unsignedBigInteger('idRutaUnidad')->index('boletos_idrutaunidad_foreign');
            $table->unsignedBigInteger('idDestinoIntermedio')->index('boletos_iddestinointermedio_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boletos');
    }
};
