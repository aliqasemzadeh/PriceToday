<?php

use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new
#[Layout('layouts::user')]
class extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function updatePassword(): void
    {
        $validated = $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => $validated['password'],
        ]);

        Auth::logoutOtherDevices($validated['current_password']);

        $this->reset('current_password', 'password', 'password_confirmation');

        Flux::toast(__('price-today.user.change_password.success'));
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'current_password' => __('price-today.user.current_password'),
            'password' => __('price-today.auth.password'),
            'password_confirmation' => __('price-today.auth.password_confirmation'),
        ];
    }

    public function render()
    {
        return $this->view()
            ->title(__('price-today.user.change_password.title'));
    }
};
?>

<div>
    <flux:heading size="xl">{{ __('price-today.user.change_password.title') }}</flux:heading>

    <flux:separator variant="subtle" class="my-8" />

    <x-user.settings-section
        :heading="__('price-today.user.change_password.heading')"
        :subheading="__('price-today.user.change_password.description')"
        class="pb-10"
    >
        <form wire:submit="updatePassword" class="space-y-6">
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
                wire:model="password"
                :label="__('price-today.user.new_password')"
                type="password"
                viewable
                autocomplete="new-password"
                :placeholder="__('price-today.auth.password_placeholder')"
            />

            <flux:input
                wire:model="password_confirmation"
                :label="__('price-today.auth.password_confirmation')"
                type="password"
                viewable
                autocomplete="new-password"
                :placeholder="__('price-today.auth.password_placeholder')"
            />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" color="orange" class="w-full">
                    {{ __('price-today.user.save') }}
                </flux:button>
            </div>
        </form>
    </x-user.settings-section>
</div>
