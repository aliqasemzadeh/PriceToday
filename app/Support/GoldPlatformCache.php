<?php

namespace App\Support;

use App\Models\PriceToday\GoldPlatform;
use Illuminate\Support\Facades\Cache;

class GoldPlatformCache
{
    private const STATS_KEY = 'gold-platforms.stats';

    private const PLATFORM_KEY_PREFIX = 'gold-platform.';

    public static function ttl(): int
    {
        return (int) config('price-today.gold-platform-cache-ttl', 3600);
    }

    public static function platformKey(string $slug): string
    {
        return self::PLATFORM_KEY_PREFIX.$slug;
    }

    /**
     * @return array{
     *     total: int,
     *     avg_buy_fee: float|null,
     *     live_price_count: int,
     *     mobile_app_count: int
     * }
     */
    public static function stats(): array
    {
        return Cache::remember(self::STATS_KEY, self::ttl(), function () {
            $platforms = GoldPlatform::query()
                ->active()
                ->get([
                    'buy_fee_percent',
                    'has_live_website_price',
                    'has_ios_app',
                    'has_android_app',
                ]);

            return [
                'total' => $platforms->count(),
                'avg_buy_fee' => $platforms->whereNotNull('buy_fee_percent')->avg('buy_fee_percent'),
                'live_price_count' => $platforms->where('has_live_website_price', true)->count(),
                'mobile_app_count' => $platforms->filter(
                    fn (GoldPlatform $platform) => $platform->has_ios_app || $platform->has_android_app
                )->count(),
            ];
        });
    }

    public static function findBySlug(string $slug): ?GoldPlatform
    {
        $platformId = Cache::remember(self::platformKey($slug), self::ttl(), function () use ($slug) {
            return GoldPlatform::query()
                ->active()
                ->where('slug', $slug)
                ->value('id');
        });

        if ($platformId === null) {
            return null;
        }

        return GoldPlatform::query()->find($platformId);
    }

    public static function forget(?GoldPlatform $platform = null): void
    {
        Cache::forget(self::STATS_KEY);

        if ($platform !== null) {
            Cache::forget(self::platformKey($platform->slug));
        }
    }

    public static function forgetSlug(string $slug): void
    {
        Cache::forget(self::platformKey($slug));
        Cache::forget(self::STATS_KEY);
    }
}
