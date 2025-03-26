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
        Schema::table('boletos', function (Blueprint $table) {
            $table->foreign(['idDestinoIntermedio'])->references(['idDestinoIntermedio'])->on('destinos_intermedios')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idRutaUnidad'])->references(['idRutaUnidad'])->on('ruta_unidad')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boletos', function (Blueprint $table) {
            $table->dropForeign('boletos_iddestinointermedio_foreign');
            $table->dropForeign('boletos_idrutaunidad_foreign');
        });
    }
};
