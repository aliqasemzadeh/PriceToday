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
        Schema::create('symbols', function (Blueprint $table) {
            $table->id();
            $table->string('symbol')->unique()->index();
            $table->string('title');
            $table->string('coingecko_id');
            $table->string('coingecko_number');
            $table->bigInteger('sort_order')->default(1);
            $table->double('price')->nullable();
            $table->double('market_cap')->nullable();
            $table->double('change_24h')->nullable();
            $table->double('vol_24h')->nullable();
            $table->string('options')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('symbols');
    }
};
