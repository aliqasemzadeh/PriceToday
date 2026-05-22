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
        Schema::create('gold_platforms', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('website_url');
            $table->string('referral_website_url')->nullable();

            $table->text('description')->nullable();

            $table->boolean('has_uniform_buy_sell_price')->nullable();

            $table->unsignedBigInteger('daily_withdrawal_limit_toman')->nullable();

            $table->boolean('supports_bullion_delivery')->nullable();
            $table->boolean('supports_plaque_delivery')->nullable();
            $table->boolean('supports_parsian_coin_delivery')->nullable();
            $table->boolean('supports_molten_gold_delivery')->nullable();

            $table->boolean('has_iso_certificate')->nullable();
            $table->boolean('has_national_business_license')->nullable();
            $table->boolean('has_guild_union_license')->nullable();
            $table->boolean('has_fintech_license')->nullable();
            $table->boolean('has_virtual_union_license')->nullable();
            $table->boolean('has_electronic_trust_symbol')->nullable();

            $table->decimal('buy_fee_percent', 5, 2)->nullable();
            $table->decimal('sell_fee_percent', 5, 2)->nullable();
            $table->decimal('withdrawal_fee_percent', 5, 2)->nullable();

            $table->boolean('supports_transfer')->nullable();
            $table->decimal('transfer_fee_percent', 5, 2)->nullable();

            $table->boolean('has_live_website_price')->nullable();
            $table->boolean('has_ios_app')->nullable();
            $table->boolean('has_android_app')->nullable();

            $table->boolean('supports_credit_purchase')->nullable();
            $table->boolean('has_referral_code')->nullable();
            $table->boolean('has_physical_store')->nullable();
            $table->boolean('supports_gift_card')->nullable();

            $table->text('union_price_difference_note')->nullable();

            $table->json('meta')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_platforms');
    }
};
