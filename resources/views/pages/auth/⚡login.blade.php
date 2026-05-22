<?php

use App\Support\IranianMobileNormalizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Sadegh19b\LaravelPersianValidation\Rules\IranianMobile;

new #[Layout('layouts::auth')] class extends Component
{
    #[Validate('required|string')]
    public string $identifier = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $isEmail = $this->isEmailIdentifier();

        if (! $isEmail) {
            $this->identifier = IranianMobileNormalizer::normalize($this->identifier);
        }

        $this->validate([
            'identifier' => array_filter([
                'required',
                'string',
                $isEmail ? 'email' : new IranianMobile(format: 'zero', convertPersianNumbers: true),
            ]),
            'password' => ['required'],
        ]);

        $user = $isEmail
            ? Auth::getProvider()->retrieveByCredentials(['email' => $this->identifier])
            : Auth::getProvider()->retrieveByCredentials(['mobile' => $this->identifier]);

        if (! $user || ! Hash::check($this->password, $user->getAuthPassword())) {
            $this->addError('identifier', __('price-today.auth.invalid_credentials'));

            return;
        }

        Auth::login($user, $this->remember);

        session()->regenerate();

        $this->redirectIntended(default: route('administrator.dashboard'), navigate: true);
    }

    protected function isEmailIdentifier(): bool
    {
        return str_contains($this->identifier, '@');
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        return [
            'identifier' => __('price-today.auth.identifier'),
            'password' => __('price-today.auth.password'),
        ];
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

            <flux:heading class="text-center" size="xl">{{ __('price-today.auth.welcome_back') }}</flux:heading>

            <form wire:submit="login" class="flex flex-col gap-6">
                <flux:input
                    wire:model="identifier"
                    :label="__('price-today.auth.identifier')"
                    type="text"
                    inputmode="text"
                    autocomplete="username"
                    placeholder="{{ __('price-today.auth.identifier_placeholder') }}"
                />

                <flux:field>
                    <div class="mb-3 flex justify-between">
                        <flux:label>{{ __('price-today.auth.password') }}</flux:label>

                        <flux:link href="#" variant="subtle" class="text-sm">{{ __('price-today.auth.forgot_password') }}</flux:link>
                    </div>

                    <flux:input
                        wire:model="password"
                        type="password"
                        viewable
                        autocomplete="current-password"
                        placeholder="{{ __('price-today.auth.password_placeholder') }}"
                    />
                </flux:field>

                <flux:checkbox wire:model="remember" :label="__('price-today.auth.remember_me')" />

                <flux:button variant="primary" type="submit" class="w-full">{{ __('price-today.auth.log_in') }}</flux:button>
            </form>

            <flux:subheading class="text-center">
                {{ __('price-today.auth.sign_up_prompt') }}
                <flux:link href="{{ route('register') }}" wire:navigate>{{ __('price-today.auth.sign_up_link') }}</flux:link>
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
                {{ __('price-today.auth.testimonial') }}
            </div>

            <div class="flex gap-4">
                <flux:avatar src="https://fluxui.dev/img/demo/caleb.png" size="xl" />

                <div class="flex flex-col justify-center font-medium">
                    <div class="text-lg">{{ __('price-today.auth.testimonial_author') }}</div>
                    <div class="text-zinc-300">{{ __('price-today.auth.testimonial_role') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
