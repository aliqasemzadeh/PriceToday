<?php

namespace App\Support;

use App\Models\PriceToday\GoldPlatform;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GoldPlatformFormData
{
    /**
     * @return array<string, mixed>
     */
    public static function validationRules(?int $ignoreId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('gold_platforms', 'slug')->ignore($ignoreId),
            ],
            'logo' => ['nullable', 'image', 'max:2048'],
            'website_url' => ['required', 'url', 'max:255'],
            'referral_website_url' => ['nullable', 'url', 'max:255'],
            'description' => ['nullable', 'string'],
            'has_uniform_buy_sell_price' => ['nullable', 'in:1,0,'],
            'daily_withdrawal_limit_million' => ['nullable', 'numeric', 'min:0'],
            'supports_bullion_delivery' => ['nullable', 'in:1,0,'],
            'supports_plaque_delivery' => ['nullable', 'in:1,0,'],
            'supports_parsian_coin_delivery' => ['nullable', 'in:1,0,'],
            'supports_molten_gold_delivery' => ['nullable', 'in:1,0,'],
            'has_iso_certificate' => ['nullable', 'in:1,0,'],
            'has_national_business_license' => ['nullable', 'in:1,0,'],
            'has_guild_union_license' => ['nullable', 'in:1,0,'],
            'has_fintech_license' => ['nullable', 'in:1,0,'],
            'has_virtual_union_license' => ['nullable', 'in:1,0,'],
            'has_electronic_trust_symbol' => ['nullable', 'in:1,0,'],
            'buy_fee_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'sell_fee_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'withdrawal_fee_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'supports_transfer' => ['nullable', 'in:1,0,'],
            'transfer_fee_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'has_live_website_price' => ['nullable', 'in:1,0,'],
            'has_ios_app' => ['nullable', 'in:1,0,'],
            'has_android_app' => ['nullable', 'in:1,0,'],
            'supports_credit_purchase' => ['nullable', 'in:1,0,'],
            'has_referral_code' => ['nullable', 'in:1,0,'],
            'has_physical_store' => ['nullable', 'in:1,0,'],
            'supports_gift_card' => ['nullable', 'in:1,0,'],
            'union_price_difference_note' => ['nullable', 'string'],
            'meta_credit_purchase_visible' => ['nullable', 'in:1,0,'],
            'meta_digipay_label' => ['nullable', 'string', 'max:255'],
            'meta_digipay_fee_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'meta_snapp_pay_label' => ['nullable', 'string', 'max:255'],
            'meta_snapp_pay_fee_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'meta_snapp_pay_note' => ['nullable', 'string', 'max:255'],
            'meta_gift_card_visible' => ['nullable', 'in:1,0,'],
            'meta_gift_card_types' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['required', 'in:1,0'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
        ];
    }

    public static function loadFromModel(object $component, GoldPlatform $platform): void
    {
        $meta = $platform->meta ?? [];

        $component->name = $platform->name;
        $component->slug = $platform->slug;
        $component->existingLogoUrl = $platform->logoUrl();
        $component->website_url = $platform->website_url;
        $component->referral_website_url = $platform->referral_website_url ?? '';
        $component->description = $platform->description ?? '';
        $component->has_uniform_buy_sell_price = self::triStateToString($platform->has_uniform_buy_sell_price);
        $component->daily_withdrawal_limit_million = $platform->daily_withdrawal_limit_toman !== null
            ? (string) ($platform->daily_withdrawal_limit_toman / 1_000_000)
            : '';
        $component->supports_bullion_delivery = self::triStateToString($platform->supports_bullion_delivery);
        $component->supports_plaque_delivery = self::triStateToString($platform->supports_plaque_delivery);
        $component->supports_parsian_coin_delivery = self::triStateToString($platform->supports_parsian_coin_delivery);
        $component->supports_molten_gold_delivery = self::triStateToString($platform->supports_molten_gold_delivery);
        $component->has_iso_certificate = self::triStateToString($platform->has_iso_certificate);
        $component->has_national_business_license = self::triStateToString($platform->has_national_business_license);
        $component->has_guild_union_license = self::triStateToString($platform->has_guild_union_license);
        $component->has_fintech_license = self::triStateToString($platform->has_fintech_license);
        $component->has_virtual_union_license = self::triStateToString($platform->has_virtual_union_license);
        $component->has_electronic_trust_symbol = self::triStateToString($platform->has_electronic_trust_symbol);
        $component->buy_fee_percent = self::decimalToString($platform->buy_fee_percent);
        $component->sell_fee_percent = self::decimalToString($platform->sell_fee_percent);
        $component->withdrawal_fee_percent = self::decimalToString($platform->withdrawal_fee_percent);
        $component->supports_transfer = self::triStateToString($platform->supports_transfer);
        $component->transfer_fee_percent = self::decimalToString($platform->transfer_fee_percent);
        $component->has_live_website_price = self::triStateToString($platform->has_live_website_price);
        $component->has_ios_app = self::triStateToString($platform->has_ios_app);
        $component->has_android_app = self::triStateToString($platform->has_android_app);
        $component->supports_credit_purchase = self::triStateToString($platform->supports_credit_purchase);
        $component->has_referral_code = self::triStateToString($platform->has_referral_code);
        $component->has_physical_store = self::triStateToString($platform->has_physical_store);
        $component->supports_gift_card = self::triStateToString($platform->supports_gift_card);
        $component->union_price_difference_note = $platform->union_price_difference_note ?? '';
        $component->meta_credit_purchase_visible = self::triStateToString($meta['credit_purchase']['visible'] ?? true);
        $component->meta_digipay_label = $meta['credit_purchase']['digipay']['label'] ?? 'دیجی‌پی';
        $component->meta_digipay_fee_percent = self::decimalToString($meta['credit_purchase']['digipay']['fee_percent'] ?? null);
        $component->meta_snapp_pay_label = $meta['credit_purchase']['snapp_pay']['label'] ?? 'اسنپ‌پی';
        $component->meta_snapp_pay_fee_percent = self::decimalToString($meta['credit_purchase']['snapp_pay']['fee_percent'] ?? null);
        $component->meta_snapp_pay_note = $meta['credit_purchase']['snapp_pay']['note'] ?? '';
        $component->meta_gift_card_visible = self::triStateToString($meta['gift_card']['visible'] ?? true);
        $component->meta_gift_card_types = implode('، ', $meta['gift_card']['types'] ?? []);
        $component->is_active = $platform->is_active ? '1' : '0';
        $component->sort_order = (string) $platform->sort_order;
    }

    /**
     * @return array<string, mixed>
     */
    public static function payloadFromComponent(object $component): array
    {
        return [
            'name' => $component->name,
            'slug' => Str::slug($component->slug),
            'website_url' => $component->website_url,
            'referral_website_url' => $component->referral_website_url !== '' ? $component->referral_website_url : null,
            'description' => self::nullableString($component->description),
            'has_uniform_buy_sell_price' => self::stringToTriState($component->has_uniform_buy_sell_price),
            'daily_withdrawal_limit_toman' => self::millionToToman($component->daily_withdrawal_limit_million),
            'supports_bullion_delivery' => self::stringToTriState($component->supports_bullion_delivery),
            'supports_plaque_delivery' => self::stringToTriState($component->supports_plaque_delivery),
            'supports_parsian_coin_delivery' => self::stringToTriState($component->supports_parsian_coin_delivery),
            'supports_molten_gold_delivery' => self::stringToTriState($component->supports_molten_gold_delivery),
            'has_iso_certificate' => self::stringToTriState($component->has_iso_certificate),
            'has_national_business_license' => self::stringToTriState($component->has_national_business_license),
            'has_guild_union_license' => self::stringToTriState($component->has_guild_union_license),
            'has_fintech_license' => self::stringToTriState($component->has_fintech_license),
            'has_virtual_union_license' => self::stringToTriState($component->has_virtual_union_license),
            'has_electronic_trust_symbol' => self::stringToTriState($component->has_electronic_trust_symbol),
            'buy_fee_percent' => self::nullableDecimal($component->buy_fee_percent),
            'sell_fee_percent' => self::nullableDecimal($component->sell_fee_percent),
            'withdrawal_fee_percent' => self::nullableDecimal($component->withdrawal_fee_percent),
            'supports_transfer' => self::stringToTriState($component->supports_transfer),
            'transfer_fee_percent' => self::nullableDecimal($component->transfer_fee_percent),
            'has_live_website_price' => self::stringToTriState($component->has_live_website_price),
            'has_ios_app' => self::stringToTriState($component->has_ios_app),
            'has_android_app' => self::stringToTriState($component->has_android_app),
            'supports_credit_purchase' => self::stringToTriState($component->supports_credit_purchase),
            'has_referral_code' => self::stringToTriState($component->has_referral_code),
            'has_physical_store' => self::stringToTriState($component->has_physical_store),
            'supports_gift_card' => self::stringToTriState($component->supports_gift_card),
            'union_price_difference_note' => self::nullableString($component->union_price_difference_note),
            'meta' => self::metaFromComponent($component),
            'is_active' => $component->is_active === '1',
            'sort_order' => (int) $component->sort_order,
        ];
    }

    public static function resetComponent(object $component): void
    {
        $component->name = '';
        $component->slug = '';
        $component->logo = null;
        $component->existingLogoUrl = null;
        $component->website_url = '';
        $component->referral_website_url = '';
        $component->description = '';
        $component->has_uniform_buy_sell_price = '';
        $component->daily_withdrawal_limit_million = '';
        $component->supports_bullion_delivery = '';
        $component->supports_plaque_delivery = '';
        $component->supports_parsian_coin_delivery = '';
        $component->supports_molten_gold_delivery = '';
        $component->has_iso_certificate = '';
        $component->has_national_business_license = '';
        $component->has_guild_union_license = '';
        $component->has_fintech_license = '';
        $component->has_virtual_union_license = '';
        $component->has_electronic_trust_symbol = '';
        $component->buy_fee_percent = '';
        $component->sell_fee_percent = '';
        $component->withdrawal_fee_percent = '';
        $component->supports_transfer = '';
        $component->transfer_fee_percent = '';
        $component->has_live_website_price = '';
        $component->has_ios_app = '';
        $component->has_android_app = '';
        $component->supports_credit_purchase = '';
        $component->has_referral_code = '';
        $component->has_physical_store = '';
        $component->supports_gift_card = '';
        $component->union_price_difference_note = '';
        $component->meta_credit_purchase_visible = '1';
        $component->meta_digipay_label = 'دیجی‌پی';
        $component->meta_digipay_fee_percent = '';
        $component->meta_snapp_pay_label = 'اسنپ‌پی';
        $component->meta_snapp_pay_fee_percent = '';
        $component->meta_snapp_pay_note = '';
        $component->meta_gift_card_visible = '1';
        $component->meta_gift_card_types = '';
        $component->is_active = '1';
        $component->sort_order = '0';
    }

    /**
     * @return array<string, mixed>
     */
    private static function metaFromComponent(object $component): array
    {
        $meta = [];

        if ($component->supports_credit_purchase === '1' || $component->meta_digipay_fee_percent !== '' || $component->meta_snapp_pay_fee_percent !== '') {
            $meta['credit_purchase'] = [
                'visible' => self::stringToTriState($component->meta_credit_purchase_visible) ?? true,
                'digipay' => array_filter([
                    'label' => $component->meta_digipay_label !== '' ? $component->meta_digipay_label : 'دیجی‌پی',
                    'fee_percent' => self::nullableDecimal($component->meta_digipay_fee_percent),
                ], fn ($value) => $value !== null),
                'snapp_pay' => array_filter([
                    'label' => $component->meta_snapp_pay_label !== '' ? $component->meta_snapp_pay_label : 'اسنپ‌پی',
                    'fee_percent' => self::nullableDecimal($component->meta_snapp_pay_fee_percent),
                    'note' => self::nullableString($component->meta_snapp_pay_note),
                ], fn ($value) => $value !== null),
            ];
        }

        $giftCardTypes = collect(preg_split('/[,،]/u', (string) $component->meta_gift_card_types) ?: [])
            ->map(fn (string $type) => trim($type))
            ->filter()
            ->values()
            ->all();

        if ($component->supports_gift_card === '1' || $giftCardTypes !== []) {
            $meta['gift_card'] = [
                'visible' => self::stringToTriState($component->meta_gift_card_visible) ?? true,
                'types' => $giftCardTypes,
            ];
        }

        return $meta === [] ? [] : $meta;
    }

    private static function triStateToString(?bool $value): string
    {
        return match ($value) {
            true => '1',
            false => '0',
            default => '',
        };
    }

    private static function stringToTriState(string $value): ?bool
    {
        return match ($value) {
            '1' => true,
            '0' => false,
            default => null,
        };
    }

    private static function decimalToString(mixed $value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        return rtrim(rtrim((string) $value, '0'), '.');
    }

    private static function nullableDecimal(string $value): ?string
    {
        if ($value === '') {
            return null;
        }

        return number_format((float) $value, 2, '.', '');
    }

    private static function nullableString(string $value): ?string
    {
        $trimmed = trim($value);

        return $trimmed === '' ? null : $trimmed;
    }

    private static function millionToToman(string $value): ?int
    {
        if ($value === '') {
            return null;
        }

        return (int) round(((float) $value) * 1_000_000);
    }
}
