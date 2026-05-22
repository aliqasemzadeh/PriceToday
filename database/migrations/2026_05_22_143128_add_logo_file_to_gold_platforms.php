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
        Schema::table('gold_platforms', function (Blueprint $table) {
            $table->string('logo_file')->nullable()->after('slug');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_platforms', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('logo_file');
        });
    }
};
