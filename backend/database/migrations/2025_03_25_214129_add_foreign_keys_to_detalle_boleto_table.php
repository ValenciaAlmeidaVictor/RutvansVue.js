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
        Schema::table('detalle_boleto', function (Blueprint $table) {
            $table->foreign(['idBoleto'])->references(['idBoleto'])->on('boletos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_boleto', function (Blueprint $table) {
            $table->dropForeign('detalle_boleto_idboleto_foreign');
        });
    }
};
