<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new
#[Layout('layouts::user')]
class extends Component
{
    public function render()
    {
        return $this->view()
            ->title(__('price-today.user.dashboard.title'));
    }
};
?>

<div>
    <flux:heading size="xl">{{ __('price-today.user.dashboard.title') }}</flux:heading>
    <flux:subheading class="mt-2">{{ __('price-today.user.dashboard.subheading') }}</flux:subheading>

    <flux:separator variant="subtle" class="my-8" />

    <x-user.settings-section
        :heading="__('price-today.user.dashboard.profile_heading')"
        :subheading="__('price-today.user.dashboard.profile_subheading')"
    >
        <flux:card class="space-y-4">
            <div class="flex items-center gap-4">
                <flux:avatar :name="auth()->user()->name" size="lg" />

                <div>
                    <flux:heading size="lg">{{ auth()->user()->name }}</flux:heading>
                    <flux:text class="mt-1">{{ auth()->user()->mobile }}</flux:text>
                    @if(auth()->user()->email)
                        <flux:text variant="subtle">{{ auth()->user()->email }}</flux:text>
                    @endif
                </div>
            </div>
        </flux:card>
    </x-user.settings-section>

    <flux:separator variant="subtle" class="my-8" />

    <x-user.settings-section
        :heading="__('price-today.user.dashboard.security_heading')"
        :subheading="__('price-today.user.dashboard.security_subheading')"
        class="pb-10"
    >
        <div class="space-y-3">
            <flux:card class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <flux:icon.lock class="size-5 text-zinc-500" />

                    <div>
                        <flux:heading size="sm">{{ __('price-today.user.menu.change_password') }}</flux:heading>
                        <flux:text variant="subtle" class="text-sm">{{ __('price-today.user.change_password.description') }}</flux:text>
                    </div>
                </div>

                <flux:button href="{{ route('user.change-password') }}" variant="ghost" icon="chevron-left" wire:navigate />
            </flux:card>

            <flux:card class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <flux:icon.mail class="size-5 text-zinc-500" />

                    <div>
                        <flux:heading size="sm">{{ __('price-today.user.menu.change_email') }}</flux:heading>
                        <flux:text variant="subtle" class="text-sm">
                            {{ auth()->user()->email ?: __('price-today.user.dashboard.no_email') }}
                        </flux:text>
                    </div>
                </div>

                <flux:button href="{{ route('user.change-email') }}" variant="ghost" icon="chevron-left" wire:navigate />
            </flux:card>

            <flux:card class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <flux:icon.smartphone class="size-5 text-zinc-500" />

                    <div>
                        <flux:heading size="sm">{{ __('price-today.user.menu.change_mobile') }}</flux:heading>
                        <flux:text variant="subtle" class="text-sm">{{ auth()->user()->mobile }}</flux:text>
                    </div>
                </div>

                <flux:button href="{{ route('user.change-mobile') }}" variant="ghost" icon="chevron-left" wire:navigate />
            </flux:card>
        </div>
    </x-user.settings-section>
</div>
