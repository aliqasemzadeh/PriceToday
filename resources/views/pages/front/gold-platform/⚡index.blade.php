<?php

use App\Models\PriceToday\GoldPlatform;
use App\Support\GoldPlatformCache;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts::front')] class extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public string $viewMode = 'list';

    public string $sortBy = 'sort_order';

    public string $sortDirection = 'asc';

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function stats(): array
    {
        $data = GoldPlatformCache::stats();

        return [
            [
                'title' => __('price-today.front.stats.total_platforms'),
                'value' => (string) $data['total'],
                'hint' => __('price-today.front.stats.total_platforms_hint'),
            ],
            [
                'title' => __('price-today.front.stats.avg_buy_fee'),
                'value' => $data['avg_buy_fee'] !== null
                    ? rtrim(rtrim(number_format((float) $data['avg_buy_fee'], 2, '.', ''), '0'), '.').'%'
                    : '—',
                'hint' => __('price-today.front.stats.avg_buy_fee_hint'),
            ],
            [
                'title' => __('price-today.front.stats.live_price'),
                'value' => (string) $data['live_price_count'],
                'hint' => __('price-today.front.stats.live_price_hint'),
            ],
            [
                'title' => __('price-today.front.stats.mobile_apps'),
                'value' => (string) $data['mobile_app_count'],
                'hint' => __('price-today.front.stats.mobile_apps_hint'),
            ],
        ];
    }

    #[Computed]
    public function platforms()
    {
        return GoldPlatform::query()
            ->active()
            ->when($this->search !== '', function ($query) {
                $query->where('slug', 'like', '%'.$this->search.'%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function render()
    {
        return $this->view()
            ->title(__('price-today.front.home_title'));
    }
};
?>

<div>
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <flux:heading size="xl">{{ __('price-today.front.home_heading') }}</flux:heading>
            <flux:subheading class="mt-1">{{ __('price-today.front.home_subheading') }}</flux:subheading>
        </div>

        <flux:tabs wire:model="viewMode" variant="segmented" class="w-auto!" size="sm">
            <flux:tab name="list" icon="list-bullet" icon:variant="outline" />
            <flux:tab name="grid" icon="squares-2x2" icon:variant="outline" />
        </flux:tabs>
    </div>

    <div class="flex gap-4 mb-6 overflow-x-auto">
        @foreach ($this->stats as $stat)
            <div @class([
                'relative shrink-0 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 min-w-44 flex-1',
                'max-md:hidden' => $loop->iteration > 1,
                'max-lg:hidden' => $loop->iteration > 3,
            ])>
                <flux:subheading>{{ $stat['title'] }}</flux:subheading>
                <flux:heading size="xl" class="mb-1">{{ $stat['value'] }}</flux:heading>
                <flux:text class="text-sm text-zinc-500 dark:text-zinc-400">{{ $stat['hint'] }}</flux:text>
            </div>
        @endforeach
    </div>

    <flux:card class="space-y-4 mb-6">
        <flux:input
            wire:model.live.debounce.300ms="search"
            icon="search"
            :placeholder="__('price-today.front.search_placeholder')"
            clearable
            dir="ltr"
        />

        @if ($viewMode === 'list')
            <flux:table :paginate="$this->platforms">
                <flux:table.columns>
                    <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">
                        {{ __('price-today.gold_platforms.name') }}
                    </flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'slug'" :direction="$sortDirection" wire:click="sort('slug')" class="max-md:hidden">
                        {{ __('price-today.gold_platforms.slug') }}
                    </flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'buy_fee_percent'" :direction="$sortDirection" wire:click="sort('buy_fee_percent')" class="max-lg:hidden">
                        {{ __('price-today.gold_platforms.buy_fee_percent') }}
                    </flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'sell_fee_percent'" :direction="$sortDirection" wire:click="sort('sell_fee_percent')" class="max-lg:hidden">
                        {{ __('price-today.gold_platforms.sell_fee_percent') }}
                    </flux:table.column>
                    <flux:table.column class="max-md:hidden">{{ __('price-today.front.features') }}</flux:table.column>
                    <flux:table.column align="end">{{ __('price-today.front.actions') }}</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->platforms as $platform)
                        <flux:table.row :key="$platform->id">
                            <flux:table.cell>
                                <div class="flex items-center gap-3">
                                    @if ($platform->logoUrl())
                                        <img src="{{ $platform->logoUrl() }}" alt="" class="size-9 rounded-full object-cover ring-1 ring-zinc-200 dark:ring-zinc-600" />
                                    @else
                                        <flux:avatar size="sm" :name="$platform->name" />
                                    @endif

                                    <div>
                                        <div class="font-medium">{{ $platform->name }}</div>
                                        <div class="text-xs text-zinc-500 md:hidden" dir="ltr">{{ $platform->slug }}</div>
                                    </div>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell class="max-md:hidden" dir="ltr">
                                <flux:badge color="zinc" size="sm" inset="top bottom">{{ $platform->slug }}</flux:badge>
                            </flux:table.cell>

                            <flux:table.cell class="max-lg:hidden whitespace-nowrap">
                                {{ $platform->formattedPercent($platform->buy_fee_percent !== null ? (float) $platform->buy_fee_percent : null) }}
                            </flux:table.cell>

                            <flux:table.cell class="max-lg:hidden whitespace-nowrap">
                                {{ $platform->formattedPercent($platform->sell_fee_percent !== null ? (float) $platform->sell_fee_percent : null) }}
                            </flux:table.cell>

                            <flux:table.cell class="max-md:hidden">
                                <div class="flex flex-wrap gap-1">
                                    @if ($platform->has_live_website_price)
                                        <flux:badge color="sky" size="sm">{{ __('price-today.front.badges.live_price') }}</flux:badge>
                                    @endif
                                    @if ($platform->has_ios_app || $platform->has_android_app)
                                        <flux:badge color="violet" size="sm">{{ __('price-today.front.badges.mobile_app') }}</flux:badge>
                                    @endif
                                    @if ($platform->has_physical_store)
                                        <flux:badge color="amber" size="sm">{{ __('price-today.front.badges.physical_store') }}</flux:badge>
                                    @endif
                                </div>
                            </flux:table.cell>

                            <flux:table.cell align="end">
                                <flux:tooltip content="{{ __('price-today.front.view_details') }}">
                                    <flux:button
                                        size="xs"
                                        variant="primary"
                                        color="amber"
                                        icon="arrow-top-right-on-square"
                                        icon:variant="outline"
                                        href="{{ route('gold-platforms.view', $platform->slug) }}"
                                        wire:navigate
                                    />
                                </flux:tooltip>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="6">
                                <div class="py-8 text-center text-zinc-500">
                                    {{ __('price-today.front.no_results') }}
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        @else
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($this->platforms as $platform)
                    <a
                        href="{{ route('gold-platforms.view', $platform->slug) }}"
                        wire:navigate
                        wire:key="platform-card-{{ $platform->id }}"
                        class="group rounded-xl border border-zinc-200 bg-zinc-50 p-5 transition hover:border-amber-300 hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800 dark:hover:border-amber-500/50"
                    >
                        <div class="flex items-start gap-4">
                            @if ($platform->logoUrl())
                                <img src="{{ $platform->logoUrl() }}" alt="" class="size-14 rounded-xl object-cover ring-1 ring-zinc-200 dark:ring-zinc-600" />
                            @else
                                <flux:avatar size="lg" :name="$platform->name" />
                            @endif

                            <div class="min-w-0 flex-1">
                                <flux:heading size="lg" class="group-hover:text-amber-600 dark:group-hover:text-amber-400">
                                    {{ $platform->name }}
                                </flux:heading>
                                <flux:badge color="zinc" size="sm" class="mt-1" dir="ltr">{{ $platform->slug }}</flux:badge>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div class="rounded-lg bg-white px-3 py-2 dark:bg-zinc-900">
                                <div class="text-zinc-500">{{ __('price-today.gold_platforms.buy_fee_percent') }}</div>
                                <div class="font-semibold">{{ $platform->formattedPercent($platform->buy_fee_percent !== null ? (float) $platform->buy_fee_percent : null) }}</div>
                            </div>
                            <div class="rounded-lg bg-white px-3 py-2 dark:bg-zinc-900">
                                <div class="text-zinc-500">{{ __('price-today.gold_platforms.sell_fee_percent') }}</div>
                                <div class="font-semibold">{{ $platform->formattedPercent($platform->sell_fee_percent !== null ? (float) $platform->sell_fee_percent : null) }}</div>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-1">
                            @if ($platform->has_live_website_price)
                                <flux:badge color="sky" size="sm">{{ __('price-today.front.badges.live_price') }}</flux:badge>
                            @endif
                            @if ($platform->has_ios_app || $platform->has_android_app)
                                <flux:badge color="violet" size="sm">{{ __('price-today.front.badges.mobile_app') }}</flux:badge>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-12 text-center text-zinc-500">
                        {{ __('price-today.front.no_results') }}
                    </div>
                @endforelse
            </div>

            <flux:pagination :paginator="$this->platforms" />
        @endif
    </flux:card>
</div>
