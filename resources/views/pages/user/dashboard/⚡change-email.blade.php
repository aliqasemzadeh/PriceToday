<?php

use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

new
#[Layout('layouts::user')]
class extends Component
{
    public string $current_password = '';

    public string $email = '';

    public function mount(): void
    {
        $this->email = auth()->user()->email ?? '';
    }

    public function updateEmail(): void
    {
        $validated = $this->validate([
            'current_password' => ['required', 'current_password'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(auth()->id()),
            ],
        ]);

        $user = auth()->user();
        $newEmail = $validated['email'] !== '' ? $validated['email'] : null;
        $oldEmail = $user->email;

        $user->update([
            'email' => $newEmail,
            'email_verified_at' => $newEmail !== $oldEmail ? null : $user->email_verified_at,
        ]);

        $this->reset('current_password');

        Flux::toast(__('price-today.user.change_email.success'));
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'current_password' => __('price-today.user.current_password'),
            'email' => __('price-today.auth.email'),
        ];
    }

    public function render()
    {
        return $this->view()
            ->title(__('price-today.user.change_email.title'));
    }
};
?>

<div>
    <flux:heading size="xl">{{ __('price-today.user.change_email.title') }}</flux:heading>

    <flux:separator variant="subtle" class="my-8" />

    <x-user.settings-section
        :heading="__('price-today.user.change_email.heading')"
        :subheading="__('price-today.user.change_email.description')"
        class="pb-10"
    >
        <form wire:submit="updateEmail" class="space-y-6">
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
                wire:model="email"
                :label="__('price-today.auth.email')"
                type="email"
                autocomplete="email"
                :placeholder="__('price-today.auth.email_placeholder')"
                :description="__('price-today.user.change_email.email_help')"
            />

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary" color="orange" class="w-full">
                    {{ __('price-today.user.save') }}
                </flux:button>
            </div>
        </form>
    </x-user.settings-section>
</div>
