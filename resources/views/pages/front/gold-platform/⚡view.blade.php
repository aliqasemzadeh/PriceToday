<?php

use App\Support\GoldPlatformCache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Morilog\Jalali\Jalalian;

new #[Layout('layouts::front')] class extends Component
{
    public string $slug = '';

    public function mount(string $slug): void
    {
        $this->slug = $slug;

        if ($this->platform === null) {
            abort(404);
        }
    }

    #[Computed]
    public function platform()
    {
        return GoldPlatformCache::findBySlug($this->slug);
    }

    public function render()
    {
        return $this->view()
            ->title($this->platform->name.' | '.__('price-today.front.home_title'));
    }
};
?>

<div class="space-y-6">
    <div>
        <flux:button
            href="{{ route('home') }}"
            variant="ghost"
            size="sm"
            icon="arrow-right"
            wire:navigate
        >
            {{ __('price-today.front.back_to_list') }}
        </flux:button>
    </div>

    <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-gradient-to-br from-amber-50 via-white to-orange-50 dark:border-zinc-700 dark:from-amber-950/30 dark:via-zinc-900 dark:to-orange-950/20">
        <div class="flex flex-col gap-6 p-6 md:flex-row md:items-center md:justify-between md:p-8">
            <div class="flex items-center gap-5">
                @if ($this->platform->logoUrl())
                    <img src="{{ $this->platform->logoUrl() }}" alt="" class="size-20 rounded-2xl object-cover ring-2 ring-white shadow-lg dark:ring-zinc-700" />
                @else
                    <flux:avatar size="xl" :name="$this->platform->name" />
                @endif

                <div>
                    <flux:heading size="xl">{{ $this->platform->name }}</flux:heading>
                    <div class="mt-2 flex flex-wrap items-center gap-2">
                        <flux:badge color="zinc" dir="ltr">{{ $this->platform->slug }}</flux:badge>
                        <flux:badge color="green">{{ __('price-today.front.active_platform') }}</flux:badge>
                    </div>
                    @if ($this->platform->description)
                        <flux:text class="mt-3 max-w-2xl text-zinc-600 dark:text-zinc-300">
                            {{ $this->platform->description }}
                        </flux:text>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap gap-2 md:flex-col md:items-stretch">
                <flux:button
                    href="{{ $this->platform->website_url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    variant="primary"
                    color="amber"
                    icon="globe-alt"
                    class="w-full md:w-auto"
                >
                    {{ __('price-today.front.visit_website') }}
                </flux:button>

                @if ($this->platform->referral_website_url)
                    <flux:button
                        href="{{ $this->platform->referral_website_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        variant="primary"
                        color="teal"
                        icon="link"
                        class="w-full md:w-auto"
                    >
                        {{ __('price-today.front.visit_referral') }}
                    </flux:button>
                @endif
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => __('price-today.gold_platforms.buy_fee_percent'), 'value' => $this->platform->formattedPercent($this->platform->buy_fee_percent !== null ? (float) $this->platform->buy_fee_percent : null), 'color' => 'amber'],
            ['label' => __('price-today.gold_platforms.sell_fee_percent'), 'value' => $this->platform->formattedPercent($this->platform->sell_fee_percent !== null ? (float) $this->platform->sell_fee_percent : null), 'color' => 'orange'],
            ['label' => __('price-today.gold_platforms.withdrawal_fee_percent'), 'value' => $this->platform->formattedPercent($this->platform->withdrawal_fee_percent !== null ? (float) $this->platform->withdrawal_fee_percent : null), 'color' => 'rose'],
            ['label' => __('price-today.gold_platforms.transfer_fee_percent'), 'value' => $this->platform->formattedPercent($this->platform->transfer_fee_percent !== null ? (float) $this->platform->transfer_fee_percent : null), 'color' => 'violet'],
        ] as $fee)
            <flux:card class="!p-4">
                <flux:subheading>{{ $fee['label'] }}</flux:subheading>
                <flux:heading size="lg" class="mt-1">{{ $fee['value'] }}</flux:heading>
            </flux:card>
        @endforeach
    </div>

    @if ($this->platform->formattedWithdrawalLimit())
        <flux:callout icon="banknotes" color="sky">
            <flux:callout.heading>{{ __('price-today.gold_platforms.daily_withdrawal_limit_toman') }}</flux:callout.heading>
            <flux:callout.text>{{ $this->platform->formattedWithdrawalLimit() }}</flux:callout.text>
        </flux:callout>
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        <flux:card class="space-y-4">
            <flux:heading size="lg">{{ __('price-today.administrator.gold_platforms.sections.pricing') }}</flux:heading>

            <div class="space-y-3">
                <div class="flex items-center justify-between gap-4 rounded-lg bg-zinc-50 px-4 py-3 dark:bg-zinc-900">
                    <span>{{ __('price-today.gold_platforms.has_uniform_buy_sell_price') }}</span>
                    <flux:badge :color="$this->platform->triStateBadgeColor($this->platform->has_uniform_buy_sell_price)" size="sm">
                        {{ $this->platform->displayTriState($this->platform->has_uniform_buy_sell_price) }}
                    </flux:badge>
                </div>
                <div class="flex items-center justify-between gap-4 rounded-lg bg-zinc-50 px-4 py-3 dark:bg-zinc-900">
                    <span>{{ __('price-today.gold_platforms.supports_transfer') }}</span>
                    <flux:badge :color="$this->platform->triStateBadgeColor($this->platform->supports_transfer)" size="sm">
                        {{ $this->platform->displayTriState($this->platform->supports_transfer) }}
                    </flux:badge>
                </div>
                <div class="flex items-center justify-between gap-4 rounded-lg bg-zinc-50 px-4 py-3 dark:bg-zinc-900">
                    <span>{{ __('price-today.gold_platforms.has_live_website_price') }}</span>
                    <flux:badge :color="$this->platform->triStateBadgeColor($this->platform->has_live_website_price)" size="sm">
                        {{ $this->platform->displayTriState($this->platform->has_live_website_price) }}
                    </flux:badge>
                </div>
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading size="lg">{{ __('price-today.administrator.gold_platforms.sections.features') }}</flux:heading>

            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ([
                    'has_ios_app' => 'device-phone-mobile',
                    'has_android_app' => 'device-phone-mobile',
                    'supports_credit_purchase' => 'credit-card',
                    'has_referral_code' => 'ticket',
                    'has_physical_store' => 'building-storefront',
                    'supports_gift_card' => 'gift',
                ] as $field => $icon)
                    <div class="flex items-center justify-between gap-3 rounded-lg bg-zinc-50 px-3 py-2.5 dark:bg-zinc-900">
                        <div class="flex items-center gap-2 text-sm">
                            <flux:icon :icon="$icon" variant="outline" class="size-4 text-zinc-500" />
                            <span>{{ __('price-today.gold_platforms.'.$field) }}</span>
                        </div>
                        <flux:badge :color="$this->platform->triStateBadgeColor($this->platform->{$field})" size="sm">
                            {{ $this->platform->displayTriState($this->platform->{$field}) }}
                        </flux:badge>
                    </div>
                @endforeach
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading size="lg">{{ __('price-today.administrator.gold_platforms.sections.delivery') }}</flux:heading>

            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ([
                    'supports_bullion_delivery',
                    'supports_plaque_delivery',
                    'supports_parsian_coin_delivery',
                    'supports_molten_gold_delivery',
                ] as $field)
                    <div class="flex items-center justify-between gap-3 rounded-lg bg-zinc-50 px-3 py-2.5 dark:bg-zinc-900">
                        <span class="text-sm">{{ __('price-today.gold_platforms.'.$field) }}</span>
                        <flux:badge :color="$this->platform->triStateBadgeColor($this->platform->{$field})" size="sm">
                            {{ $this->platform->displayTriState($this->platform->{$field}) }}
                        </flux:badge>
                    </div>
                @endforeach
            </div>
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading size="lg">{{ __('price-today.administrator.gold_platforms.sections.licenses') }}</flux:heading>

            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ([
                    'has_iso_certificate',
                    'has_national_business_license',
                    'has_guild_union_license',
                    'has_fintech_license',
                    'has_virtual_union_license',
                    'has_electronic_trust_symbol',
                ] as $field)
                    <div class="flex items-center justify-between gap-3 rounded-lg bg-zinc-50 px-3 py-2.5 dark:bg-zinc-900">
                        <span class="text-sm">{{ __('price-today.gold_platforms.'.$field) }}</span>
                        <flux:badge :color="$this->platform->triStateBadgeColor($this->platform->{$field})" size="sm">
                            {{ $this->platform->displayTriState($this->platform->{$field}) }}
                        </flux:badge>
                    </div>
                @endforeach
            </div>
        </flux:card>
    </div>

    @php
        $meta = $this->platform->meta ?? [];
        $creditPurchase = $meta['credit_purchase'] ?? null;
        $giftCard = $meta['gift_card'] ?? null;
        $showCredit = is_array($creditPurchase) && ($creditPurchase['visible'] ?? true) !== false;
        $showGiftCard = is_array($giftCard) && ($giftCard['visible'] ?? true) !== false;
    @endphp

    @if ($showCredit || $showGiftCard)
        <div class="grid gap-6 lg:grid-cols-2">
            @if ($showCredit)
                <flux:card class="space-y-4">
                    <flux:heading size="lg">{{ __('price-today.administrator.gold_platforms.meta_credit_purchase') }}</flux:heading>

                    <div class="space-y-3">
                        @if (isset($creditPurchase['digipay']))
                            <div class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                                <div class="font-medium">{{ $creditPurchase['digipay']['label'] ?? __('price-today.administrator.gold_platforms.meta_digipay_label') }}</div>
                                @if (isset($creditPurchase['digipay']['fee_percent']))
                                    <flux:text class="mt-1">
                                        {{ __('price-today.administrator.gold_platforms.meta_digipay_fee') }}:
                                        {{ rtrim(rtrim(number_format((float) $creditPurchase['digipay']['fee_percent'], 2, '.', ''), '0'), '.') }}%
                                    </flux:text>
                                @endif
                            </div>
                        @endif

                        @if (isset($creditPurchase['snapp_pay']))
                            <div class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                                <div class="font-medium">{{ $creditPurchase['snapp_pay']['label'] ?? __('price-today.administrator.gold_platforms.meta_snapp_pay_label') }}</div>
                                @if (isset($creditPurchase['snapp_pay']['fee_percent']))
                                    <flux:text class="mt-1">
                                        {{ __('price-today.administrator.gold_platforms.meta_snapp_pay_fee') }}:
                                        {{ rtrim(rtrim(number_format((float) $creditPurchase['snapp_pay']['fee_percent'], 2, '.', ''), '0'), '.') }}%
                                    </flux:text>
                                @endif
                                @if (! empty($creditPurchase['snapp_pay']['note']))
                                    <flux:text class="mt-1 text-zinc-500">{{ $creditPurchase['snapp_pay']['note'] }}</flux:text>
                                @endif
                            </div>
                        @endif
                    </div>
                </flux:card>
            @endif

            @if ($showGiftCard && ! empty($giftCard['types']))
                <flux:card class="space-y-4">
                    <flux:heading size="lg">{{ __('price-today.administrator.gold_platforms.meta_gift_card') }}</flux:heading>

                    <div class="flex flex-wrap gap-2">
                        @foreach ($giftCard['types'] as $type)
                            <flux:badge color="fuchsia" size="lg" rounded>{{ $type }}</flux:badge>
                        @endforeach
                    </div>
                </flux:card>
            @endif
        </div>
    @endif

    @if ($this->platform->union_price_difference_note)
        <flux:callout icon="information-circle" color="amber">
            <flux:callout.heading>{{ __('price-today.gold_platforms.union_price_difference_note') }}</flux:callout.heading>
            <flux:callout.text>{{ $this->platform->union_price_difference_note }}</flux:callout.text>
        </flux:callout>
    @endif

    <flux:text class="text-sm text-zinc-500">
        {{ __('price-today.front.last_updated') }}:
        {{ Jalalian::fromDateTime($this->platform->updated_at)->format('Y/m/d H:i') }}
    </flux:text>
</div>
