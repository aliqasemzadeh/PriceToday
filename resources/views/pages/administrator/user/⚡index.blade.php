<?php

use App\Models\User;
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

    public string $sortBy = 'created_at';

    public string $sortDirection = 'desc';

    public function mount(): void
    {
        $this->authorize('manage-users');
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

    #[On('panels.administrator.user.saved')]
    public function refreshUsers(): void
    {
        unset($this->users);
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('mobile', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function render()
    {
        return $this->view()
            ->title(__('price-today.administrator.menu.users'));
    }
};
?>

<div class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <flux:heading size="xl">{{ __('price-today.administrator.menu.users') }}</flux:heading>

        @can('user-create')
            <flux:tooltip content="{{ __('price-today.administrator.users.create') }}">
                <flux:button
                    variant="primary"
                    color="teal"
                    icon="plus"
                    wire:click="$dispatch('panels.administrator.user.create.assign-data')"
                />
            </flux:tooltip>
        @endcan
    </div>

    <flux:card class="space-y-4">
        <flux:input
            wire:model.live.debounce.300ms="search"
            icon="search"
            :placeholder="__('price-today.administrator.users.search_placeholder')"
            clearable
        />

        <flux:table :paginate="$this->users">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'name'" :direction="$sortDirection" wire:click="sort('name')">
                    {{ __('price-today.administrator.users.name') }}
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'mobile'" :direction="$sortDirection" wire:click="sort('mobile')">
                    {{ __('price-today.administrator.users.mobile') }}
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'email'" :direction="$sortDirection" wire:click="sort('email')">
                    {{ __('price-today.administrator.users.email') }}
                </flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">
                    {{ __('price-today.administrator.users.created_at') }}
                </flux:table.column>
                @can('user-edit')
                    <flux:table.column align="end">{{ __('price-today.administrator.users.actions') }}</flux:table.column>
                @endcan
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->users as $user)
                    <flux:table.row :key="$user->id">
                        <flux:table.cell class="flex items-center gap-3">
                            <flux:avatar size="xs" :name="$user->name" />

                            {{ $user->name }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">{{ $user->mobile }}</flux:table.cell>

                        <flux:table.cell>{{ $user->email ?? '—' }}</flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ Jalalian::fromDateTime($user->created_at)->format('Y/m/d H:i') }}
                        </flux:table.cell>

                        @can('user-edit')
                            <flux:table.cell align="end">
                                <flux:tooltip content="{{ __('price-today.administrator.users.edit') }}">
                                    <flux:button
                                        size="xs"
                                        variant="primary"
                                        color="blue"
                                        icon="pencil"
                                        icon:variant="outline"
                                        wire:click="$dispatch('panels.administrator.user.edit.assign-data', { userId: {{ $user->id }} })"
                                    />
                                </flux:tooltip>
                            </flux:table.cell>
                        @endcan
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    @can('user-create')
        <livewire:administrator.user.create :key="'administrator-user-create'" />
    @endcan
    @can('user-edit')
        <livewire:administrator.user.edit :key="'administrator-user-edit'" />
    @endcan
</div>
