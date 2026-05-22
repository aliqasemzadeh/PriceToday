<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Layout('layouts::auth')] class extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', __('app.auth.invalid_credentials'));

            return;
        }

        session()->regenerate();

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

            <flux:heading class="text-center" size="xl">{{ __('app.auth.welcome_back') }}</flux:heading>

            <div class="space-y-4">
                <flux:button class="w-full" type="button">
                    <x-slot name="icon">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.06 12.25C23.06 11.47 22.99 10.72 22.86 10H12.5V14.26H18.42C18.16 15.63 17.38 16.79 16.21 17.57V20.34H19.78C21.86 18.42 23.06 15.6 23.06 12.25Z" fill="#4285F4"/>
                            <path d="M12.4997 23C15.4697 23 17.9597 22.02 19.7797 20.34L16.2097 17.57C15.2297 18.23 13.9797 18.63 12.4997 18.63C9.63969 18.63 7.20969 16.7 6.33969 14.1H2.67969V16.94C4.48969 20.53 8.19969 23 12.4997 23Z" fill="#34A853"/>
                            <path d="M6.34 14.0899C6.12 13.4299 5.99 12.7299 5.99 11.9999C5.99 11.2699 6.12 10.5699 6.34 9.90995V7.06995H2.68C1.93 8.54995 1.5 10.2199 1.5 11.9999C1.5 13.7799 1.93 15.4499 2.68 16.9299L5.53 14.7099L6.34 14.0899Z" fill="#FBBC05"/>
                            <path d="M12.4997 5.38C14.1197 5.38 15.5597 5.94 16.7097 7.02L19.8597 3.87C17.9497 2.09 15.4697 1 12.4997 1C8.19969 1 4.48969 3.47 2.67969 7.07L6.33969 9.91C7.20969 7.31 9.63969 5.38 12.4997 5.38Z" fill="#EA4335"/>
                        </svg>
                    </x-slot>

                    {{ __('app.auth.continue_with_google') }}
                </flux:button>

                <flux:button class="w-full" type="button">
                    <x-slot name="icon">
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_login_github)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4642 0C5.84833 0 0.5 5.5 0.5 12.3043C0.5 17.7433 3.92686 22.3473 8.68082 23.9768C9.27518 24.0993 9.4929 23.712 9.4929 23.3863C9.4929 23.101 9.47331 22.1233 9.47331 21.1045C6.14514 21.838 5.45208 19.6378 5.45208 19.6378C4.91723 18.2118 4.12474 17.8453 4.12474 17.8453C3.03543 17.0915 4.20408 17.0915 4.20408 17.0915C5.41241 17.173 6.04645 18.3545 6.04645 18.3545C7.11592 20.2285 8.83927 19.699 9.53257 19.373C9.63151 18.5785 9.94865 18.0285 10.2854 17.723C7.63094 17.4378 4.83812 16.3785 4.83812 11.6523C4.83812 10.3078 5.31323 9.20775 6.06604 8.35225C5.94727 8.04675 5.53118 6.7835 6.18506 5.09275C6.18506 5.09275 7.19527 4.76675 9.47306 6.35575C10.4483 6.08642 11.454 5.9494 12.4642 5.94825C13.4745 5.94825 14.5042 6.091 15.4552 6.35575C17.7332 4.76675 18.7434 5.09275 18.7434 5.09275C19.3973 6.7835 18.981 8.04675 18.8622 8.35225C19.6349 9.20775 20.0904 10.3078 20.0904 11.6523C20.0904 16.3785 17.2976 17.4173 14.6233 17.723C15.0592 18.11 15.4353 18.8433 15.4353 20.0045C15.4353 21.6545 15.4158 22.9788 15.4158 23.386C15.4158 23.712 15.6337 24.0993 16.2278 23.977C20.9818 22.347 24.4087 17.7433 24.4087 12.3043C24.4282 5.5 19.0603 0 12.4642 0Z" fill="currentColor"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_login_github">
                                    <rect width="24" height="24" fill="white" transform="translate(0.5)"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </x-slot>

                    {{ __('app.auth.continue_with_github') }}
                </flux:button>
            </div>

            <flux:separator text="{{ __('app.auth.or') }}" />

            <form wire:submit="login" class="flex flex-col gap-6">
                <flux:input
                    wire:model="email"
                    :label="__('app.auth.email')"
                    type="email"
                    placeholder="{{ __('app.auth.email_placeholder') }}"
                />

                <flux:field>
                    <div class="mb-3 flex justify-between">
                        <flux:label>{{ __('app.auth.password') }}</flux:label>

                        <flux:link href="#" variant="subtle" class="text-sm">{{ __('app.auth.forgot_password') }}</flux:link>
                    </div>

                    <flux:input
                        wire:model="password"
                        type="password"
                        placeholder="{{ __('app.auth.password_placeholder') }}"
                    />
                </flux:field>

                <flux:checkbox wire:model="remember" :label="__('app.auth.remember_me')" />

                <flux:button variant="primary" type="submit" class="w-full">{{ __('app.auth.log_in') }}</flux:button>
            </form>

            <flux:subheading class="text-center">
                {{ __('app.auth.sign_up_prompt') }}
                <flux:link href="{{ route('register') }}" wire:navigate>{{ __('app.auth.sign_up_link') }}</flux:link>
            </flux:subheading>
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
