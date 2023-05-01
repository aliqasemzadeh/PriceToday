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
            $table->bigInteger('symbol_id');
            $table->bigInteger('user_id');
            $table->double('less_than')->default(0)->nullable();
            $table->double('more_than')->default(0)->nullable();
            $table->double('change_percent')->default(0)->nullable();
            $table->string('time')->default("12:00:00")->nullable();
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
