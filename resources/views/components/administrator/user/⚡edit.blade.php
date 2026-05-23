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
    public ?int $userId = null;

    public string $name = '';

    public string $mobile = '';

    public string $email = '';

    public string $password = '';

    #[On('panels.administrator.user.edit.assign-data')]
    public function assignData(int $userId): void
    {
        $this->authorize('user-edit');

        $user = User::query()->findOrFail($userId);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->mobile = $user->mobile;
        $this->email = $user->email ?? '';
        $this->password = '';

        $this->resetValidation();

        $this->modal('administrator-user-edit')->show();
    }

    public function save(): void
    {
        $this->authorize('user-edit');

        $this->mobile = IranianMobileNormalizer::normalize($this->mobile);

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => [
                'required',
                new IranianMobile(format: 'zero', convertPersianNumbers: true),
                Rule::unique('users', 'mobile')->ignore($this->userId),
            ],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->userId)],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $user = User::query()->findOrFail($this->userId);

        $data = [
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email !== '' ? $this->email : null,
        ];

        if ($this->password !== '') {
            $data['password'] = $this->password;
        }

        $user->update($data);

        $this->modal('administrator-user-edit')->close();
        $this->dispatch('panels.administrator.user.saved');

        Flux::toast(__('price-today.administrator.users.updated_success'));
    }
};
?>

<flux:modal name="administrator-user-edit" flyout position="right">
    <form wire:submit="save" class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('price-today.administrator.users.edit_title') }}</flux:heading>
            <flux:text class="mt-2">{{ __('price-today.administrator.users.edit_description') }}</flux:text>
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
            :label="__('price-today.administrator.users.password_optional')"
            type="password"
            viewable
            :placeholder="__('price-today.auth.password_placeholder')"
        />

        <flux:button type="submit" variant="primary" color="orange" class="w-full">
            {{ __('price-today.administrator.users.save') }}
        </flux:button>
    </form>
</flux:modal>
