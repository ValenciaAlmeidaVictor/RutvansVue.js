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
        Schema::create('envios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombreEmisor');
            $table->string('nombreReceptor');
            $table->double('total');
            $table->string('foto');
            $table->text('descripcion');
            $table->unsignedBigInteger('idRutaUnidad')->index('envios_idrutaunidad_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
