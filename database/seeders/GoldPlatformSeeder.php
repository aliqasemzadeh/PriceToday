<?php

namespace Database\Seeders;

use App\Models\PriceToday\GoldPlatform;
use Illuminate\Database\Seeder;

class GoldPlatformSeeder extends Seeder
{
    /**
     * Seed the application's gold platforms.
     */
    public function run(): void
    {
        GoldPlatform::query()->updateOrCreate(
            ['slug' => 'talasea'],
            [
                'name' => 'طلاسی',
                'website_url' => 'https://talasea.ir',
                'referral_website_url' => null,
                'description' => null,
                'daily_withdrawal_limit_toman' => 200_000_000,
                'buy_fee_percent' => 0.5,
                'sell_fee_percent' => 1,
                'supports_gift_card' => true,
                'meta' => [
                    'credit_purchase' => [
                        'digipay' => [
                            'label' => 'دیجی‌پی',
                            'fee_percent' => 3.5,
                        ],
                        'snapp_pay' => [
                            'label' => 'اسنپ‌پی',
                            'fee_percent' => 1,
                            'note' => 'خرید با اعتبار بانکی',
                        ],
                    ],
                    'gift_card' => [
                        'types' => ['کارت هدیه', 'کد هدیه'],
                    ],
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
        );
    }
}
