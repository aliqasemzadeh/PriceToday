<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Builder;

class GoldPlatformSearch
{
    /**
     * @return array<string, string>
     */
    public static function featureOptions(): array
    {
        return self::labeledFields([
            'has_live_website_price',
            'has_ios_app',
            'has_android_app',
            'supports_credit_purchase',
            'has_referral_code',
            'has_physical_store',
            'supports_gift_card',
            'supports_transfer',
            'has_uniform_buy_sell_price',
        ]);
    }

    /**
     * @return array<string, string>
     */
    public static function deliveryOptions(): array
    {
        return self::labeledFields([
            'supports_bullion_delivery',
            'supports_plaque_delivery',
            'supports_parsian_coin_delivery',
            'supports_molten_gold_delivery',
        ]);
    }

    /**
     * @return array<string, string>
     */
    public static function licenseOptions(): array
    {
        return self::labeledFields([
            'has_iso_certificate',
            'has_national_business_license',
            'has_guild_union_license',
            'has_fintech_license',
            'has_virtual_union_license',
            'has_electronic_trust_symbol',
        ]);
    }

    /**
     * @return array<string, string>
     */
    public static function maxBuyFeeOptions(): array
    {
        return [
            '1' => __('price-today.front.filters.max_buy_fee_1'),
            '2' => __('price-today.front.filters.max_buy_fee_2'),
            '3' => __('price-today.front.filters.max_buy_fee_3'),
            '5' => __('price-today.front.filters.max_buy_fee_5'),
        ];
    }

    /**
     * @param  array<int, string>  $features
     * @param  array<int, string>  $delivery
     * @param  array<int, string>  $licenses
     */
    public static function applyToQuery(
        Builder $query,
        string $search = '',
        string $keyword = '',
        array $features = [],
        array $delivery = [],
        array $licenses = [],
        string $maxBuyFee = '',
    ): Builder {
        if ($search !== '') {
            $query->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('slug', 'like', '%'.$search.'%');
            });
        }

        if ($keyword !== '') {
            $query->where(function (Builder $query) use ($keyword) {
                $query->where('description', 'like', '%'.$keyword.'%')
                    ->orWhere('union_price_difference_note', 'like', '%'.$keyword.'%')
                    ->orWhere('website_url', 'like', '%'.$keyword.'%')
                    ->orWhere('referral_website_url', 'like', '%'.$keyword.'%')
                    ->orWhere('meta', 'like', '%'.$keyword.'%');

                foreach (self::matchingFieldsByLabel($keyword) as $field) {
                    $query->orWhere($field, true);
                }
            });
        }

        foreach ($features as $field) {
            if (array_key_exists($field, self::featureOptions())) {
                $query->where($field, true);
            }
        }

        foreach ($delivery as $field) {
            if (array_key_exists($field, self::deliveryOptions())) {
                $query->where($field, true);
            }
        }

        foreach ($licenses as $field) {
            if (array_key_exists($field, self::licenseOptions())) {
                $query->where($field, true);
            }
        }

        if ($maxBuyFee !== '' && is_numeric($maxBuyFee)) {
            $query->where(function (Builder $query) use ($maxBuyFee) {
                $query->whereNull('buy_fee_percent')
                    ->orWhere('buy_fee_percent', '<=', (float) $maxBuyFee);
            });
        }

        return $query;
    }

    /**
     * @param  array<int, string>  $fields
     * @return array<string, string>
     */
    private static function labeledFields(array $fields): array
    {
        $options = [];

        foreach ($fields as $field) {
            $options[$field] = __('price-today.gold_platforms.'.$field);
        }

        return $options;
    }

    /**
     * @return array<int, string>
     */
    private static function matchingFieldsByLabel(string $keyword): array
    {
        $keyword = mb_strtolower(trim($keyword));

        if ($keyword === '') {
            return [];
        }

        $matches = [];

        foreach (self::allFilterOptions() as $field => $label) {
            $normalizedLabel = mb_strtolower($label);

            if (mb_strpos($normalizedLabel, $keyword) !== false || mb_strpos($keyword, $normalizedLabel) !== false) {
                $matches[] = $field;
            }
        }

        return array_values(array_unique($matches));
    }

    /**
     * @return array<string, string>
     */
    private static function allFilterOptions(): array
    {
        return self::featureOptions() + self::deliveryOptions() + self::licenseOptions();
    }
}
