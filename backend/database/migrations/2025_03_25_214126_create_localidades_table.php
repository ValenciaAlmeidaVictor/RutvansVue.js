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
        Schema::create('localidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('locality');
            $table->string('street');
            $table->string('postal_code');
            $table->timestamps(); // Esto agrega las columnas `created_at` y `updated_at`
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localidades');
    }
};
