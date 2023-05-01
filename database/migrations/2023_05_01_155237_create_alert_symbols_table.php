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
        Schema::create('alert_symbols', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('symbol_id')->index();
            $table->bigInteger('user_id')->index();
            $table->double('less_than')->default(0)->nullable();
            $table->double('more_than')->default(0)->nullable();
            $table->double('change_percent')->default(0)->nullable();
            $table->double('hour')->default("11")->nullable();
            $table->double('minute')->default("59")->nullable();
            $table->string('display_unit')->default("USDT")->index();
            $table->string('status')->default("active")->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_symbols');
    }
};
