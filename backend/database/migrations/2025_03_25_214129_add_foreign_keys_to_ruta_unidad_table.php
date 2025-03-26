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
        Schema::table('ruta_unidad', function (Blueprint $table) {
            $table->foreign(['idRuta'])->references(['idRuta'])->on('rutas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['idUnidad'])->references(['idUnidad'])->on('unidades')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ruta_unidad', function (Blueprint $table) {
            $table->dropForeign('ruta_unidad_idruta_foreign');
            $table->dropForeign('ruta_unidad_idunidad_foreign');
        });
    }
};
