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
        <flux:sidebar sticky collapsible="mobile" class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <flux:sidebar.brand
                    href="{{ route('administrator.dashboard') }}"
                    name="{{ config('app.name') }}"
                    wire:navigate
                >
                    <x-slot name="logo">
                        <svg class="size-5 text-zinc-800 dark:text-white" viewBox="0 0 18 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <line x1="1" y1="5" x2="1" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <line x1="5" y1="1" x2="5" y2="8" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <line x1="9" y1="5" x2="9" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <line x1="13" y1="1" x2="13" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                <line x1="17" y1="5" x2="17" y2="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </g>
                        </svg>
                    </x-slot>
                </flux:sidebar.brand>

                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.item
                    icon="layout-dashboard"
                    href="{{ route('administrator.dashboard') }}"
                    :current="request()->routeIs('administrator.dashboard')"
                    wire:navigate
                >
                    {{ __('price-today.administrator.menu.dashboard') }}
                </flux:sidebar.item>

                @can('manage-users')
                    <flux:sidebar.item
                        icon="users"
                        href="{{ route('administrator.users') }}"
                        :current="request()->routeIs('administrator.users*')"
                        wire:navigate
                    >
                        {{ __('price-today.administrator.menu.users') }}
                    </flux:sidebar.item>
                @endcan

                @can('manage-platforms')
                    <flux:sidebar.item
                        icon="coins"
                        href="{{ route('administrator.gold-platforms') }}"
                        :current="request()->routeIs('administrator.gold-platforms*')"
                        wire:navigate
                    >
                        {{ __('price-today.administrator.menu.gold_platforms') }}
                    </flux:sidebar.item>
                @endcan
            </flux:sidebar.nav>

            <flux:sidebar.spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item
                    icon="log-out"
                    href="{{ route('logout') }}"
                    wire:navigate
                >
                    {{ __('price-today.auth.logout_button') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            @auth
                <flux:dropdown position="top" align="start" class="max-lg:hidden">
                    <flux:sidebar.profile :name="auth()->user()->name" />

                    <flux:menu>
                        <flux:menu.item icon="log-out" href="{{ route('logout') }}" wire:navigate>
                            {{ __('price-today.auth.logout_button') }}
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            @endauth
        </flux:sidebar>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="menu" inset="left" />

            <flux:spacer />

            @auth
                <flux:dropdown position="top" align="start">
                    <flux:profile :name="auth()->user()->name" />

                    <flux:menu>
                        <flux:menu.item icon="log-out" href="{{ route('logout') }}" wire:navigate>
                            {{ __('price-today.auth.logout_button') }}
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            @endauth
        </flux:header>

        <flux:main>
            {{ $slot }}
        </flux:main>

        @livewireScripts
        @fluxScripts
    </body>
</html>
