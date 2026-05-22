<?php

use App\Models\User;
use App\Support\IranianMobileNormalizer;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Sadegh19b\LaravelPersianValidation\Rules\IranianMobile;

new #[Layout('layouts::auth')] class extends Component
{
    public string $name = '';

    public string $mobile = '';

    public string $email = '';

    public string $password = '';

    public function register(): void
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

        $user = User::create([
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email !== '' ? $this->email : null,
            'password' => $this->password,
        ]);

        Auth::login($user);

        session()->regenerate();

        Flux::toast(__('app.auth.registered_success'));

        $this->redirectIntended(default: route('home'), navigate: true);
    }
};
?>

<div class="flex min-h-screen">
    <div class="flex flex-1 items-center justify-center">
        <div class="w-80 max-w-80 space-y-6">
            <div class="flex justify-center opacity-50">
                <a href="{{ route('home') }}" class="group flex items-center gap-3" wire:navigate>
                    <div>
                        <svg class="h-4 text-zinc-800 dark:text-white" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <line x1="1" y1="5" x2="1" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                                <line x1="5" y1="1" x2="5" y2="8" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                                <line x1="9" y1="5" x2="9" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                                <line x1="13" y1="1" x2="13" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                                <line x1="17" y1="5" x2="17" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round"></line>
                            </g>
                        </svg>
                    </div>

                    <span class="text-xl font-semibold text-zinc-800 dark:text-white">{{ config('app.name') }}</span>
                </a>
            </div>

            <flux:heading class="text-center" size="xl">{{ __('app.auth.register_title') }}</flux:heading>

            <form wire:submit="register" class="flex flex-col gap-6">
                <flux:input
                    wire:model="name"
                    :label="__('app.auth.name')"
                    type="text"
                    autocomplete="name"
                    placeholder="{{ __('app.auth.name_placeholder') }}"
                />

                <flux:input
                    wire:model="mobile"
                    :label="__('app.auth.mobile')"
                    type="tel"
                    inputmode="tel"
                    autocomplete="tel"
                    placeholder="{{ __('app.auth.mobile_placeholder') }}"
                />

                <flux:input
                    wire:model="email"
                    :label="__('app.auth.email_optional')"
                    type="email"
                    autocomplete="email"
                    placeholder="{{ __('app.auth.email_placeholder') }}"
                />

                <flux:input
                    wire:model="password"
                    :label="__('app.auth.password')"
                    type="password"
                    viewable
                    autocomplete="new-password"
                    placeholder="{{ __('app.auth.password_placeholder') }}"
                />

                <flux:button variant="primary" color="orange" type="submit" class="w-full">{{ __('app.auth.register') }}</flux:button>
            </form>

            <flux:subheading class="text-center">
                {{ __('app.auth.log_in_prompt') }}
                <flux:link href="{{ route('login') }}" wire:navigate>{{ __('app.auth.log_in_link') }}</flux:link>
            </flux:subheading>

            <flux:radio.group variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun">Light</flux:radio>
                <flux:radio value="dark" icon="moon">Dark</flux:radio>
                <flux:radio value="system" icon="computer-desktop">System</flux:radio>
            </flux:radio.group>
        </div>
    </div>

    <div class="flex-1 p-4 max-lg:hidden">
        <div
            class="relative flex h-full w-full flex-col items-start justify-end rounded-lg bg-zinc-900 p-16 text-white"
            style="background-image: url('https://fluxui.dev/img/demo/auth_aurora_2x.png'); background-size: cover"
        >
            <div class="mb-4 flex gap-2">
                <flux:icon.star variant="solid" />
                <flux:icon.star variant="solid" />
                <flux:icon.star variant="solid" />
                <flux:icon.star variant="solid" />
                <flux:icon.star variant="solid" />
            </div>

            <div class="font-base mb-6 text-3xl italic xl:text-4xl">
                {{ __('app.auth.testimonial') }}
            </div>

            <div class="flex gap-4">
                <flux:avatar src="https://fluxui.dev/img/demo/caleb.png" size="xl" />

                <div class="flex flex-col justify-center font-medium">
                    <div class="text-lg">{{ __('app.auth.testimonial_author') }}</div>
                    <div class="text-zinc-300">{{ __('app.auth.testimonial_role') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
