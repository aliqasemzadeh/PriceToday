<?php

use App\Models\PriceToday\GoldPlatform;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Morilog\Jalali\Jalalian;

new
#[Layout('layouts::administrator')]
class extends Component
{
    use WithPagination;

    public string $search = '';

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

    #[On('panels.administrator.gold-platform.saved')]
    public function refreshGoldPlatforms(): void
    {
        unset($this->goldPlatforms);
    }

    public function delete(int $goldPlatformId): void
    {
        GoldPlatform::query()->findOrFail($goldPlatformId)->delete();

        unset($this->goldPlatforms);

        Flux::toast(__('price-today.administrator.gold_platforms.deleted_success'));
    }

    #[Computed]
    public function goldPlatforms()
    {
        return GoldPlatform::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('slug', 'like', '%'.$this->search.'%')
                        ->orWhere('website_url', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function render()
    {
        return $this->view()
            ->title(__('price-today.administrator.menu.gold_platforms'));
    }
};
?>

<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <flux:heading size="xl">{{ __('price-today.administrator.menu.gold_platforms') }}</flux:heading>

        <flux:tooltip content="{{ __('price-today.administrator.gold_platforms.create') }}">
            <flux:button
                variant="primary"
                color="teal"
                icon="plus"
                wire:click="$dispatch('panels.administrator.gold-platform.create.assign-data')"
            />
        </flux:tooltip>
    </div>

    <flux:card class="space-y-4">
        <flux:input
            wire:model.live.debounce.300ms="search"
            icon="search"
            :placeholder="__('price-today.administrator.gold_platforms.search_placeholder')"
            clearable
        />

        <flux:table :paginate="$this->goldPlatforms">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">
                    {{ __('price-today.gold_platforms.name') }}
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'website_url'" :direction="$sortDirection" wire:click="sort('website_url')">
                    {{ __('price-today.gold_platforms.website_url') }}
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'buy_fee_percent'" :direction="$sortDirection" wire:click="sort('buy_fee_percent')">
                    {{ __('price-today.gold_platforms.buy_fee_percent') }}
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'is_active'" :direction="$sortDirection" wire:click="sort('is_active')">
                    {{ __('price-today.gold_platforms.is_active') }}
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'sort_order'" :direction="$sortDirection" wire:click="sort('sort_order')">
                    {{ __('price-today.gold_platforms.sort_order') }}
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'updated_at'" :direction="$sortDirection" wire:click="sort('updated_at')">
                    {{ __('price-today.administrator.gold_platforms.updated_at') }}
                </flux:table.column>
                <flux:table.column align="end">{{ __('price-today.administrator.gold_platforms.actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->goldPlatforms as $platform)
                    <flux:table.row :key="$platform->id">
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                @if ($platform->logoUrl())
                                    <img src="{{ $platform->logoUrl() }}" alt="" class="size-8 rounded-full object-cover" />
                                @else
                                    <flux:avatar size="xs" :name="$platform->name" />
                                @endif

                                <div>
                                    <div class="font-medium">{{ $platform->name }}</div>
                                    <div class="text-xs text-zinc-500" dir="ltr">{{ $platform->slug }}</div>
                                </div>
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <a href="{{ $platform->website_url }}" target="_blank" rel="noopener noreferrer" class="text-sky-600 hover:underline" dir="ltr">
                                {{ parse_url($platform->website_url, PHP_URL_HOST) ?: $platform->website_url }}
                            </a>
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            @if ($platform->buy_fee_percent !== null)
                                {{ rtrim(rtrim(number_format((float) $platform->buy_fee_percent, 2, '.', ''), '0'), '.') }}%
                            @else
                                —
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            @if ($platform->is_active)
                                <flux:badge color="green" size="sm">{{ __('price-today.administrator.gold_platforms.active') }}</flux:badge>
                            @else
                                <flux:badge color="zinc" size="sm">{{ __('price-today.administrator.gold_platforms.inactive') }}</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>{{ $platform->sort_order }}</flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ Jalalian::fromDateTime($platform->updated_at)->format('Y/m/d H:i') }}
                        </flux:table.cell>

                        <flux:table.cell align="end">
                            <div class="flex items-center justify-end gap-1">
                                <flux:tooltip content="{{ __('price-today.administrator.gold_platforms.edit') }}">
                                    <flux:button
                                        size="xs"
                                        variant="primary"
                                        color="blue"
                                        icon="pencil"
                                        icon:variant="outline"
                                        wire:click="$dispatch('panels.administrator.gold-platform.edit.assign-data', { goldPlatformId: {{ $platform->id }} })"
                                    />
                                </flux:tooltip>

                                <flux:tooltip content="{{ __('price-today.administrator.gold_platforms.delete') }}">
                                    <flux:button
                                        size="xs"
                                        variant="primary"
                                        color="red"
                                        icon="trash"
                                        icon:variant="outline"
                                        wire:click="delete({{ $platform->id }})"
                                        wire:confirm="{{ __('price-today.administrator.gold_platforms.delete_confirm') }}"
                                    />
                                </flux:tooltip>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <livewire:administrator.gold-platform.create :key="'administrator-gold-platform-create'" />
    <livewire:administrator.gold-platform.edit :key="'administrator-gold-platform-edit'" />
</div>
