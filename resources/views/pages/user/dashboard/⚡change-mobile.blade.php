<?php

use App\Support\IranianMobileNormalizer;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Sadegh19b\LaravelPersianValidation\Rules\IranianMobile;

new
#[Layout('layouts::user')]
class extends Component
{
    public string $current_password = '';

    public string $mobile = '';

    public function mount(): void
    {
        $this->mobile = auth()->user()->mobile;
    }

    public function updateMobile(): void
    {
        $this->mobile = IranianMobileNormalizer::normalize($this->mobile);

        $validated = $this->validate([
            'current_password' => ['required', 'current_password'],
            'mobile' => [
                'required',
                new IranianMobile(format: 'zero', convertPersianNumbers: true),
                Rule::unique('users', 'mobile')->ignore(auth()->id()),
            ],
        ]);

        auth()->user()->update([
            'mobile' => $validated['mobile'],
        ]);

        $this->mobile = $validated['mobile'];
        $this->reset('current_password');

        Flux::toast(__('price-today.user.change_mobile.success'));
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'current_password' => __('price-today.user.current_password'),
            'mobile' => __('price-today.auth.mobile'),
        ];
    }

    public function render()
    {
        return $this->view()
            ->title(__('price-today.user.change_mobile.title'));
    }
};
?>

<div>
    <flux:heading size="xl">{{ __('price-today.user.change_mobile.title') }}</flux:heading>

    <flux:separator variant="subtle" class="my-8" />

    <x-user.settings-section
        :heading="__('price-today.user.change_mobile.heading')"
        :subheading="__('price-today.user.change_mobile.description')"
        class="pb-10"
    >
        <form wire:submit="updateMobile" class="space-y-6">
            <flux:input
                wire:model="current_password"
                :label="__('price-today.user.current_password')"
                type="password"
                viewable
                autocomplete="current-password"
                :placeholder="__('price-today.user.current_password_placeholder')"
            />

            <flux:separator variant="subtle" />

            <flux:input
                wire:model="mobile"
                :label="__('price-today.auth.mobile')"
                type="tel"
                inputmode="tel"
                autocomplete="tel"
                :placeholder="__('price-today.auth.mobile_placeholder')"
                :description="__('price-today.user.change_mobile.mobile_help')"
            />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" color="orange" class="w-full">
                    {{ __('price-today.user.save') }}
                </flux:button>
            </div>
        </form>
    </x-user.settings-section>
</div>
