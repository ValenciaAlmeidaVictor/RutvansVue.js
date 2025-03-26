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
        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombrePasajero');
            $table->double('importe');
            $table->double('descuento');
            $table->double('ivaTotal');
            $table->unsignedBigInteger('idVenta')->index('detalle_venta_idventa_foreign');
            $table->unsignedBigInteger('idBoleto')->index('detalle_venta_idboleto_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_venta');
    }
};
