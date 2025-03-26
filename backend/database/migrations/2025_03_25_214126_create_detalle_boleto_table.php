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
        Schema::create('detalle_boleto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numeroAsiento');
            $table->double('precioAsiento');
            $table->unsignedBigInteger('idBoleto')->index('detalle_boleto_idboleto_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_boleto');
    }
};
