<?php

use App\Models\PriceToday\GoldPlatform;
use App\Support\GoldPlatformFormData;
use App\Support\GoldPlatformLogoStorage;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $slug = '';

    public $logo = null;

    public ?string $existingLogoUrl = null;

    public string $website_url = '';

    public string $referral_website_url = '';

    public string $description = '';

    public string $has_uniform_buy_sell_price = '';

    public string $daily_withdrawal_limit_million = '';

    public string $supports_bullion_delivery = '';

    public string $supports_plaque_delivery = '';

    public string $supports_parsian_coin_delivery = '';

    public string $supports_molten_gold_delivery = '';

    public string $has_iso_certificate = '';

    public string $has_national_business_license = '';

    public string $has_guild_union_license = '';

    public string $has_fintech_license = '';

    public string $has_virtual_union_license = '';

    public string $has_electronic_trust_symbol = '';

    public string $buy_fee_percent = '';

    public string $sell_fee_percent = '';

    public string $withdrawal_fee_percent = '';

    public string $supports_transfer = '';

    public string $transfer_fee_percent = '';

    public string $has_live_website_price = '';

    public string $has_ios_app = '';

    public string $has_android_app = '';

    public string $supports_credit_purchase = '';

    public string $has_referral_code = '';

    public string $has_physical_store = '';

    public string $supports_gift_card = '';

    public string $union_price_difference_note = '';

    public string $meta_credit_purchase_visible = '1';

    public string $meta_digipay_label = 'دیجی‌پی';

    public string $meta_digipay_fee_percent = '';

    public string $meta_snapp_pay_label = 'اسنپ‌پی';

    public string $meta_snapp_pay_fee_percent = '';

    public string $meta_snapp_pay_note = '';

    public string $meta_gift_card_visible = '1';

    public string $meta_gift_card_types = '';

    public string $is_active = '1';

    public string $sort_order = '0';

    #[On('panels.administrator.gold-platform.create.assign-data')]
    public function assignData(): void
    {
        GoldPlatformFormData::resetComponent($this);
        $this->logo = null;
        $this->resetValidation();

        $this->modal('administrator-gold-platform-create')->show();
    }

    public function updatedName(): void
    {
        if ($this->slug === '') {
            $this->slug = Str::slug($this->name);
        }
    }

    public function save(): void
    {
        $this->validate(GoldPlatformFormData::validationRules());

        $payload = GoldPlatformFormData::payloadFromComponent($this);

        if ($this->logo !== null) {
            $payload['logo_file'] = GoldPlatformLogoStorage::store($this->logo);
        }

        GoldPlatform::query()->create($payload);

        $this->modal('administrator-gold-platform-create')->close();
        $this->dispatch('panels.administrator.gold-platform.saved');

        Flux::toast(__('price-today.administrator.gold_platforms.created_success'));
    }
};
?>

<flux:modal name="administrator-gold-platform-create" flyout position="right" class="max-w-2xl">
    <form wire:submit="save" class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('price-today.administrator.gold_platforms.create_title') }}</flux:heading>
            <flux:text class="mt-2">{{ __('price-today.administrator.gold_platforms.create_description') }}</flux:text>
        </div>

        @include('components.administrator.gold-platform.form-fields')

        <flux:button type="submit" variant="primary" color="orange" class="w-full">
            {{ __('price-today.administrator.gold_platforms.save') }}
        </flux:button>
    </form>
</flux:modal>
