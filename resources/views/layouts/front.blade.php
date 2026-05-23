<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
        @fluxAppearance
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-zinc-800">
        <flux:header sticky container class="bg-white dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-600">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" />

            <flux:navbar class="max-lg:hidden -mb-px">
                <flux:navbar.item
                    href="{{ route('home') }}"
                    :current="request()->routeIs('home')"
                    wire:navigate
                >
                    {{ __('price-today.front.nav.platforms') }}
                </flux:navbar.item>
            </flux:navbar>

            <flux:spacer />

            <div class="flex items-center gap-2">
                @guest
                    <flux:button href="{{ route('login') }}" variant="ghost" size="sm" wire:navigate>
                        {{ __('price-today.auth.log_in') }}
                    </flux:button>
                    <flux:button href="{{ route('register') }}" variant="primary" color="amber" size="sm" wire:navigate>
                        {{ __('price-today.auth.register') }}
                    </flux:button>
                @endguest

                @auth
                    <flux:button href="{{ route('administrator.dashboard') }}" variant="ghost" size="sm" icon="layout-dashboard" wire:navigate>
                        {{ __('price-today.front.nav.dashboard') }}
                    </flux:button>

                    <flux:dropdown position="bottom" align="end">
                        <flux:profile :name="auth()->user()->name" />

                        <flux:menu>
                            <flux:menu.item icon="circle-user" href="{{ route('user.dashboard') }}" wire:navigate>
                                {{ __('price-today.user.menu.dashboard') }}
                            </flux:menu.item>

                            <flux:menu.separator />

                            <flux:menu.item icon="log-out" href="{{ route('logout') }}" wire:navigate>
                                {{ __('price-today.auth.logout_button') }}
                            </flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                @endauth
            </div>
        </flux:header>

        <flux:sidebar collapsible="mobile" class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <flux:sidebar.nav>
                <flux:sidebar.item
                    icon="coins"
                    href="{{ route('home') }}"
                    :current="request()->routeIs('home')"
                    wire:navigate
                >
                    {{ __('price-today.front.nav.platforms') }}
                </flux:sidebar.item>

                @guest
                    <flux:sidebar.item icon="log-in" href="{{ route('login') }}" wire:navigate>
                        {{ __('price-today.auth.log_in') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="user-plus" href="{{ route('register') }}" wire:navigate>
                        {{ __('price-today.auth.register') }}
                    </flux:sidebar.item>
                @endguest

                @auth
                    <flux:sidebar.item icon="layout-dashboard" href="{{ route('administrator.dashboard') }}" wire:navigate>
                        {{ __('price-today.front.nav.dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="log-out" href="{{ route('logout') }}" wire:navigate>
                        {{ __('price-today.auth.logout_button') }}
                    </flux:sidebar.item>
                @endauth
            </flux:sidebar.nav>
        </flux:sidebar>

        <flux:main container>
            {{ $slot }}
        </flux:main>

        @livewireScripts
        @fluxScripts
    </body>
</html>
