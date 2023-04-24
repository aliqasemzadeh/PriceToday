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
        Schema::create('user_verifies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('verification_code');
            $table->string('status')->default('registered');
            //Personal Information
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('national_code')->nullable()->unique();
            $table->string('year_birth')->nullable()->unique();
            $table->string('month_birth')->nullable()->unique();
            $table->string('day_birth')->nullable()->unique();
            $table->string('id_card_file')->nullable()->unique();
            $table->string('selfie_file')->nullable()->unique();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_verifies');
    }
};
