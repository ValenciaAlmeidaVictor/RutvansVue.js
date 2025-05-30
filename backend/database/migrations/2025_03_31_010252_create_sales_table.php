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
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('folio');
            $table->decimal('cost', 10);
            $table->unsignedBigInteger('user_id')->index('fk_sales_users');
            $table->unsignedBigInteger('origin_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('method_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
