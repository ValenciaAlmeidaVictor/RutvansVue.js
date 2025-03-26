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
        Schema::table('destinos_intermedios', function (Blueprint $table) {
            $table->foreign(['idRuta'])->references(['idRuta'])->on('rutas')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinos_intermedios', function (Blueprint $table) {
            $table->dropForeign('destinos_intermedios_idruta_foreign');
        });
    }
};
