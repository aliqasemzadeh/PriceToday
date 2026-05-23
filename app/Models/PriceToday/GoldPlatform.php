<?php

namespace App\Models\PriceToday;

use App\Support\GoldPlatformCache;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'name',
    'slug',
    'logo_file',
    'website_url',
    'referral_website_url',
    'description',
    'has_uniform_buy_sell_price',
    'daily_withdrawal_limit_toman',
    'supports_bullion_delivery',
    'supports_plaque_delivery',
    'supports_parsian_coin_delivery',
    'supports_molten_gold_delivery',
    'has_iso_certificate',
    'has_national_business_license',
    'has_guild_union_license',
    'has_fintech_license',
    'has_virtual_union_license',
    'has_electronic_trust_symbol',
    'buy_fee_percent',
    'sell_fee_percent',
    'withdrawal_fee_percent',
    'supports_transfer',
    'transfer_fee_percent',
    'has_live_website_price',
    'has_ios_app',
    'has_android_app',
    'supports_credit_purchase',
    'has_referral_code',
    'has_physical_store',
    'supports_gift_card',
    'union_price_difference_note',
    'meta',
    'is_active',
    'sort_order',
])]
class GoldPlatform extends Model
{
    use SoftDeletes;

    protected static function booted(): void
    {
        static::saved(function (GoldPlatform $platform) {
            if ($platform->wasChanged('slug')) {
                $originalSlug = $platform->getOriginal('slug');

                if (is_string($originalSlug) && $originalSlug !== '') {
                    GoldPlatformCache::forgetSlug($originalSlug);
                }
            }

            GoldPlatformCache::forget($platform);
        });

        static::deleted(function (GoldPlatform $platform) {
            GoldPlatformCache::forget($platform);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function displayTriState(?bool $value): string
    {
        if ($value === true) {
            return __('price-today.gold_platforms.yes');
        }

        if ($value === false) {
            return __('price-today.gold_platforms.no');
        }

        return __('price-today.gold_platforms.unknown');
    }

    public function triStateBadgeColor(?bool $value): string
    {
        if ($value === true) {
            return 'green';
        }

        if ($value === false) {
            return 'red';
        }

        return 'zinc';
    }

    public function formattedPercent(?float $value): string
    {
        if ($value === null) {
            return '—';
        }

        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.').'%';
    }

    public function formattedWithdrawalLimit(): ?string
    {
        if ($this->daily_withdrawal_limit_toman === null) {
            return null;
        }

        $millions = $this->daily_withdrawal_limit_toman / 1_000_000;

        return number_format($millions).' '.__('price-today.gold_platforms.million_toman');
    }

    public function logoUrl(): ?string
    {
        if ($this->logo_file === null) {
            return null;
        }

        return Storage::disk('public')->url($this->logo_file);
    }

    protected function casts(): array
    {
        return [
            'has_uniform_buy_sell_price' => 'boolean',
            'daily_withdrawal_limit_toman' => 'integer',
            'supports_bullion_delivery' => 'boolean',
            'supports_plaque_delivery' => 'boolean',
            'supports_parsian_coin_delivery' => 'boolean',
            'supports_molten_gold_delivery' => 'boolean',
            'has_iso_certificate' => 'boolean',
            'has_national_business_license' => 'boolean',
            'has_guild_union_license' => 'boolean',
            'has_fintech_license' => 'boolean',
            'has_virtual_union_license' => 'boolean',
            'has_electronic_trust_symbol' => 'boolean',
            'buy_fee_percent' => 'decimal:2',
            'sell_fee_percent' => 'decimal:2',
            'withdrawal_fee_percent' => 'decimal:2',
            'supports_transfer' => 'boolean',
            'transfer_fee_percent' => 'decimal:2',
            'has_live_website_price' => 'boolean',
            'has_ios_app' => 'boolean',
            'has_android_app' => 'boolean',
            'supports_credit_purchase' => 'boolean',
            'has_referral_code' => 'boolean',
            'has_physical_store' => 'boolean',
            'supports_gift_card' => 'boolean',
            'meta' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
