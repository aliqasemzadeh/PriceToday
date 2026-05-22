<div class="space-y-6">
    <flux:card class="space-y-4">
        <flux:heading size="sm">{{ __('price-today.administrator.gold_platforms.sections.basic') }}</flux:heading>

        <div class="flex items-start gap-6">
            <flux:file-upload wire:model="logo">
                <div @class([
                    'relative flex items-center justify-center size-20 rounded-full transition-colors cursor-pointer',
                    'border border-zinc-200 dark:border-white/10 hover:border-zinc-300 dark:hover:border-white/10',
                    'bg-zinc-100 hover:bg-zinc-200 dark:bg-white/10 hover:dark:bg-white/15 in-data-dragging:dark:bg-white/15',
                ])>
                    @if ($logo)
                        <img src="{{ $logo->temporaryUrl() }}" alt="" class="size-full object-cover rounded-full" />
                    @elseif ($existingLogoUrl ?? null)
                        <img src="{{ $existingLogoUrl }}" alt="" class="size-full object-cover rounded-full" />
                    @else
                        <flux:icon name="building-storefront" variant="solid" class="text-zinc-500 dark:text-zinc-400" />
                    @endif

                    <div class="absolute bottom-0 right-0 bg-white dark:bg-zinc-800 rounded-full">
                        <flux:icon name="arrow-up-circle" variant="solid" class="text-zinc-500 dark:text-zinc-400" />
                    </div>
                </div>
            </flux:file-upload>

            <div class="flex-1 space-y-4">
                <flux:input
                    wire:model.live.debounce.500ms="name"
                    :label="__('price-today.gold_platforms.name')"
                    :placeholder="__('price-today.administrator.gold_platforms.name_placeholder')"
                />

                <flux:input
                    wire:model="slug"
                    :label="__('price-today.gold_platforms.slug')"
                    :placeholder="__('price-today.administrator.gold_platforms.slug_placeholder')"
                    dir="ltr"
                />
            </div>
        </div>

        <flux:input
            wire:model="website_url"
            :label="__('price-today.gold_platforms.website_url')"
            :placeholder="__('price-today.administrator.gold_platforms.website_placeholder')"
            dir="ltr"
        />

        <flux:input
            wire:model="referral_website_url"
            :label="__('price-today.gold_platforms.referral_website_url')"
            :placeholder="__('price-today.administrator.gold_platforms.website_placeholder')"
            dir="ltr"
        />

        <flux:editor
            wire:model="description"
            :label="__('price-today.gold_platforms.description')"
            :description="__('price-today.administrator.gold_platforms.description_help')"
        />
    </flux:card>

    <flux:card class="space-y-4">
        <flux:heading size="sm">{{ __('price-today.administrator.gold_platforms.sections.pricing') }}</flux:heading>

        <x-administrator.gold-platform.tri-state-radio
            model="has_uniform_buy_sell_price"
            :label="__('price-today.gold_platforms.has_uniform_buy_sell_price')"
        />

        <flux:input
            wire:model="daily_withdrawal_limit_million"
            type="number"
            min="0"
            step="0.01"
            :label="__('price-today.administrator.gold_platforms.daily_withdrawal_limit_million')"
            :description="__('price-today.administrator.gold_platforms.daily_withdrawal_limit_help')"
        />

        <div class="grid gap-4 sm:grid-cols-3">
            <flux:input wire:model="buy_fee_percent" type="number" min="0" max="100" step="0.01" :label="__('price-today.gold_platforms.buy_fee_percent')" />
            <flux:input wire:model="sell_fee_percent" type="number" min="0" max="100" step="0.01" :label="__('price-today.gold_platforms.sell_fee_percent')" />
            <flux:input wire:model="withdrawal_fee_percent" type="number" min="0" max="100" step="0.01" :label="__('price-today.gold_platforms.withdrawal_fee_percent')" />
        </div>

        <x-administrator.gold-platform.tri-state-radio
            model="supports_transfer"
            :label="__('price-today.gold_platforms.supports_transfer')"
        />

        <flux:input
            wire:model="transfer_fee_percent"
            type="number"
            min="0"
            max="100"
            step="0.01"
            :label="__('price-today.gold_platforms.transfer_fee_percent')"
        />
    </flux:card>

    <flux:card class="space-y-4">
        <flux:heading size="sm">{{ __('price-today.administrator.gold_platforms.sections.delivery') }}</flux:heading>

        <div class="grid gap-4 sm:grid-cols-2">
            <x-administrator.gold-platform.tri-state-radio model="supports_bullion_delivery" :label="__('price-today.gold_platforms.supports_bullion_delivery')" />
            <x-administrator.gold-platform.tri-state-radio model="supports_plaque_delivery" :label="__('price-today.gold_platforms.supports_plaque_delivery')" />
            <x-administrator.gold-platform.tri-state-radio model="supports_parsian_coin_delivery" :label="__('price-today.gold_platforms.supports_parsian_coin_delivery')" />
            <x-administrator.gold-platform.tri-state-radio model="supports_molten_gold_delivery" :label="__('price-today.gold_platforms.supports_molten_gold_delivery')" />
        </div>
    </flux:card>

    <flux:card class="space-y-4">
        <flux:heading size="sm">{{ __('price-today.administrator.gold_platforms.sections.licenses') }}</flux:heading>

        <div class="grid gap-4 sm:grid-cols-2">
            <x-administrator.gold-platform.tri-state-radio model="has_iso_certificate" :label="__('price-today.gold_platforms.has_iso_certificate')" />
            <x-administrator.gold-platform.tri-state-radio model="has_national_business_license" :label="__('price-today.gold_platforms.has_national_business_license')" />
            <x-administrator.gold-platform.tri-state-radio model="has_guild_union_license" :label="__('price-today.gold_platforms.has_guild_union_license')" />
            <x-administrator.gold-platform.tri-state-radio model="has_fintech_license" :label="__('price-today.gold_platforms.has_fintech_license')" />
            <x-administrator.gold-platform.tri-state-radio model="has_virtual_union_license" :label="__('price-today.gold_platforms.has_virtual_union_license')" />
            <x-administrator.gold-platform.tri-state-radio model="has_electronic_trust_symbol" :label="__('price-today.gold_platforms.has_electronic_trust_symbol')" />
        </div>
    </flux:card>

    <flux:card class="space-y-4">
        <flux:heading size="sm">{{ __('price-today.administrator.gold_platforms.sections.features') }}</flux:heading>

        <div class="grid gap-4 sm:grid-cols-2">
            <x-administrator.gold-platform.tri-state-radio model="has_live_website_price" :label="__('price-today.gold_platforms.has_live_website_price')" />
            <x-administrator.gold-platform.tri-state-radio model="has_ios_app" :label="__('price-today.gold_platforms.has_ios_app')" />
            <x-administrator.gold-platform.tri-state-radio model="has_android_app" :label="__('price-today.gold_platforms.has_android_app')" />
            <x-administrator.gold-platform.tri-state-radio model="supports_credit_purchase" :label="__('price-today.gold_platforms.supports_credit_purchase')" />
            <x-administrator.gold-platform.tri-state-radio model="has_referral_code" :label="__('price-today.gold_platforms.has_referral_code')" />
            <x-administrator.gold-platform.tri-state-radio model="has_physical_store" :label="__('price-today.gold_platforms.has_physical_store')" />
            <x-administrator.gold-platform.tri-state-radio model="supports_gift_card" :label="__('price-today.gold_platforms.supports_gift_card')" />
        </div>
    </flux:card>

    <flux:card class="space-y-4">
        <flux:heading size="sm">{{ __('price-today.administrator.gold_platforms.sections.meta') }}</flux:heading>
        <flux:text>{{ __('price-today.administrator.gold_platforms.meta_help') }}</flux:text>

        <flux:separator />

        <flux:heading size="xs">{{ __('price-today.administrator.gold_platforms.meta_credit_purchase') }}</flux:heading>

        <x-administrator.gold-platform.tri-state-radio
            model="meta_credit_purchase_visible"
            :label="__('price-today.administrator.gold_platforms.meta_visible')"
        />

        <div class="grid gap-4 sm:grid-cols-2">
            <flux:input wire:model="meta_digipay_label" :label="__('price-today.administrator.gold_platforms.meta_digipay_label')" />
            <flux:input wire:model="meta_digipay_fee_percent" type="number" min="0" max="100" step="0.01" :label="__('price-today.administrator.gold_platforms.meta_digipay_fee')" />
            <flux:input wire:model="meta_snapp_pay_label" :label="__('price-today.administrator.gold_platforms.meta_snapp_pay_label')" />
            <flux:input wire:model="meta_snapp_pay_fee_percent" type="number" min="0" max="100" step="0.01" :label="__('price-today.administrator.gold_platforms.meta_snapp_pay_fee')" />
        </div>

        <flux:input wire:model="meta_snapp_pay_note" :label="__('price-today.administrator.gold_platforms.meta_snapp_pay_note')" />

        <flux:separator />

        <flux:heading size="xs">{{ __('price-today.administrator.gold_platforms.meta_gift_card') }}</flux:heading>

        <x-administrator.gold-platform.tri-state-radio
            model="meta_gift_card_visible"
            :label="__('price-today.administrator.gold_platforms.meta_visible')"
        />

        <flux:input
            wire:model="meta_gift_card_types"
            :label="__('price-today.administrator.gold_platforms.meta_gift_card_types')"
            :description="__('price-today.administrator.gold_platforms.meta_gift_card_types_help')"
            :placeholder="__('price-today.administrator.gold_platforms.meta_gift_card_types_placeholder')"
        />
    </flux:card>

    <flux:card class="space-y-4">
        <flux:heading size="sm">{{ __('price-today.administrator.gold_platforms.sections.notes') }}</flux:heading>

        <flux:editor
            wire:model="union_price_difference_note"
            :label="__('price-today.gold_platforms.union_price_difference_note')"
        />
    </flux:card>

    <flux:card class="space-y-4">
        <flux:heading size="sm">{{ __('price-today.administrator.gold_platforms.sections.settings') }}</flux:heading>

        <flux:radio.group variant="buttons" class="w-full *:flex-1" wire:model="is_active" :label="__('price-today.gold_platforms.is_active')">
            <flux:radio value="1" icon="check">{{ __('price-today.administrator.gold_platforms.active') }}</flux:radio>
            <flux:radio value="0" icon="x-mark">{{ __('price-today.administrator.gold_platforms.inactive') }}</flux:radio>
        </flux:radio.group>

        <flux:input wire:model="sort_order" type="number" min="0" max="65535" :label="__('price-today.gold_platforms.sort_order')" />
    </flux:card>
</div>
