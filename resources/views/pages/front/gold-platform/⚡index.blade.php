<?php

use App\Models\PriceToday\GoldPlatform;
use App\Support\GoldPlatformCache;
use App\Support\GoldPlatformSearch;
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

    #[Url(as: 'keyword')]
    public string $keyword = '';

    /** @var array<int, string> */
    #[Url(as: 'features')]
    public array $filterFeatures = [];

    /** @var array<int, string> */
    #[Url(as: 'delivery')]
    public array $filterDelivery = [];

    /** @var array<int, string> */
    #[Url(as: 'licenses')]
    public array $filterLicenses = [];

    #[Url(as: 'fee')]
    public string $maxBuyFee = '';

    public bool $showAdvancedFilters = false;

    public string $viewMode = 'list';

    public string $sortBy = 'sort_order';

    public string $sortDirection = 'asc';

    public function mount(): void
    {
        if ($this->keyword !== '' || $this->filterFeatures !== [] || $this->filterDelivery !== [] || $this->filterLicenses !== [] || $this->maxBuyFee !== '') {
            $this->showAdvancedFilters = true;
        }
    }

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

    public function updatedKeyword(): void
    {
        $this->resetPage();
    }

    public function updatedFilterFeatures(): void
    {
        $this->resetPage();
    }

    public function updatedFilterDelivery(): void
    {
        $this->resetPage();
    }

    public function updatedFilterLicenses(): void
    {
        $this->resetPage();
    }

    public function updatedMaxBuyFee(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->keyword = '';
        $this->filterFeatures = [];
        $this->filterDelivery = [];
        $this->filterLicenses = [];
        $this->maxBuyFee = '';
        $this->resetPage();
    }

    #[Computed]
    public function hasActiveFilters(): bool
    {
        return $this->search !== ''
            || $this->keyword !== ''
            || $this->filterFeatures !== []
            || $this->filterDelivery !== []
            || $this->filterLicenses !== []
            || $this->maxBuyFee !== '';
    }

    #[Computed]
    public function featureFilterOptions(): array
    {
        return GoldPlatformSearch::featureOptions();
    }

    #[Computed]
    public function deliveryFilterOptions(): array
    {
        return GoldPlatformSearch::deliveryOptions();
    }

    #[Computed]
    public function licenseFilterOptions(): array
    {
        return GoldPlatformSearch::licenseOptions();
    }

    #[Computed]
    public function maxBuyFeeOptions(): array
    {
        return GoldPlatformSearch::maxBuyFeeOptions();
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
        $query = GoldPlatform::query()->active();

        GoldPlatformSearch::applyToQuery(
            $query,
            $this->search,
            $this->keyword,
            $this->filterFeatures,
            $this->filterDelivery,
            $this->filterLicenses,
            $this->maxBuyFee,
        );

        return $query
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

        <flux:tabs variant="segmented" class="w-auto!" size="sm">
            <flux:tab
                name="list"
                icon="list-bullet"
                icon:variant="outline"
                wire:click="$set('viewMode', 'list')"
                :selected="$viewMode === 'list'"
            />
            <flux:tab
                name="grid"
                icon="squares-2x2"
                icon:variant="outline"
                wire:click="$set('viewMode', 'grid')"
                :selected="$viewMode === 'grid'"
            />
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
        <div class="flex flex-wrap items-end gap-3">
            <div class="min-w-0 flex-1">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    icon="search"
                    :label="__('price-today.front.search_label')"
                    :placeholder="__('price-today.front.search_placeholder')"
                    clearable
                    class="text-left"
                />
            </div>

            <flux:button
                wire:click="$toggle('showAdvancedFilters')"
                variant="ghost"
                icon="adjustments-horizontal"
                icon:variant="outline"
            >
                {{ __('price-today.front.advanced_search') }}
            </flux:button>

            @if ($this->hasActiveFilters)
                <flux:button wire:click="resetFilters" variant="ghost" color="red" size="sm" icon="x-mark">
                    {{ __('price-today.front.clear_filters') }}
                </flux:button>
            @endif
        </div>

        @if ($showAdvancedFilters)
            <div class="grid gap-4 border-t border-zinc-200 pt-4 dark:border-zinc-700 md:grid-cols-2 xl:grid-cols-3">
                <flux:input
                    wire:model.live.debounce.300ms="keyword"
                    icon="magnifying-glass"
                    :label="__('price-today.front.keyword_label')"
                    :placeholder="__('price-today.front.keyword_placeholder')"
                    clearable
                    class="text-left md:col-span-2 xl:col-span-3"
                />

                <flux:pillbox
                    wire:model.live="filterFeatures"
                    searchable
                    multiple
                    :label="__('price-today.front.filters.features')"
                    :placeholder="__('price-today.front.filters.features_placeholder')"
                >
                    @foreach ($this->featureFilterOptions as $value => $label)
                        <flux:pillbox.option :value="$value">{{ $label }}</flux:pillbox.option>
                    @endforeach
                </flux:pillbox>

                <flux:pillbox
                    wire:model.live="filterDelivery"
                    searchable
                    multiple
                    :label="__('price-today.front.filters.delivery')"
                    :placeholder="__('price-today.front.filters.delivery_placeholder')"
                >
                    @foreach ($this->deliveryFilterOptions as $value => $label)
                        <flux:pillbox.option :value="$value">{{ $label }}</flux:pillbox.option>
                    @endforeach
                </flux:pillbox>

                <flux:pillbox
                    wire:model.live="filterLicenses"
                    searchable
                    multiple
                    :label="__('price-today.front.filters.licenses')"
                    :placeholder="__('price-today.front.filters.licenses_placeholder')"
                >
                    @foreach ($this->licenseFilterOptions as $value => $label)
                        <flux:pillbox.option :value="$value">{{ $label }}</flux:pillbox.option>
                    @endforeach
                </flux:pillbox>

                <flux:select
                    wire:model.live="maxBuyFee"
                    searchable
                    :label="__('price-today.front.filters.max_buy_fee')"
                    :placeholder="__('price-today.front.filters.max_buy_fee_placeholder')"
                >
                    <flux:select.option value="">{{ __('price-today.front.filters.max_buy_fee_any') }}</flux:select.option>
                    @foreach ($this->maxBuyFeeOptions as $value => $label)
                        <flux:select.option :value="$value">{{ $label }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        @endif

        <div wire:key="platforms-view-{{ $viewMode }}">
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
        </div>
    </flux:card>
</div>
