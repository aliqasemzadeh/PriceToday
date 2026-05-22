<?php

use App\Models\User;
use App\Support\IranianMobileNormalizer;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Sadegh19b\LaravelPersianValidation\Rules\IranianMobile;

new class extends Component
{
    public string $name = '';

    public string $mobile = '';

    public string $email = '';

    public string $password = '';

    #[On('panels.administrator.user.create.assign-data')]
    public function assignData(): void
    {
        $this->reset(['name', 'mobile', 'email', 'password']);
        $this->resetValidation();

        $this->modal('administrator-user-create')->show();
    }

    public function save(): void
    {
        $this->mobile = IranianMobileNormalizer::normalize($this->mobile);

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => [
                'required',
                new IranianMobile(format: 'zero', convertPersianNumbers: true),
                Rule::unique('users', 'mobile'),
            ],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email !== '' ? $this->email : null,
            'password' => $this->password,
        ]);

        $this->modal('administrator-user-create')->close();
        $this->dispatch('panels.administrator.user.saved');

        Flux::toast(__('price-today.administrator.users.created_success'));
    }
};
?>

<flux:modal name="administrator-user-create" flyout position="right">
    <form wire:submit="save" class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('price-today.administrator.users.create_title') }}</flux:heading>
            <flux:text class="mt-2">{{ __('price-today.administrator.users.create_description') }}</flux:text>
        </div>

        <flux:input
            wire:model="name"
            :label="__('price-today.administrator.users.name')"
            :placeholder="__('price-today.auth.name_placeholder')"
        />

        <flux:input
            wire:model="mobile"
            :label="__('price-today.administrator.users.mobile')"
            type="tel"
            inputmode="tel"
            :placeholder="__('price-today.auth.mobile_placeholder')"
        />

        <flux:input
            wire:model="email"
            :label="__('price-today.administrator.users.email_optional')"
            type="email"
            :placeholder="__('price-today.auth.email_placeholder')"
        />

        <flux:input
            wire:model="password"
            :label="__('price-today.administrator.users.password')"
            type="password"
            viewable
            :placeholder="__('price-today.auth.password_placeholder')"
        />

        <flux:button type="submit" variant="primary" color="orange" class="w-full">
            {{ __('price-today.administrator.users.save') }}
        </flux:button>
    </form>
</flux:modal>
