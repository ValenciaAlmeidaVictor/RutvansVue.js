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
        Schema::table('rutas', function (Blueprint $table) {
            $table->foreign(['idLocalidadDestino'])->references(['idLocalidad'])->on('localidades')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idLocalidadOrigen'])->references(['idLocalidad'])->on('localidades')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rutas', function (Blueprint $table) {
            $table->dropForeign('rutas_idlocalidaddestino_foreign');
            $table->dropForeign('rutas_idlocalidadorigen_foreign');
        });
    }
};
