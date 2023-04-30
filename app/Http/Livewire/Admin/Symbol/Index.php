<?php

namespace App\Http\Livewire\Admin\Symbol;

use App\Models\Symbol;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $selectedItems = [];
    public $selectAll = false;

    public $symbol;
    public $search;
    public $perPage = 15;
    public $sortColumn = 'updated_at';
    public $sortDirection = 'asc';

    protected $paginationTheme = 'bootstrap';

    protected $queryString = ['search'];
    protected $listeners = [
        'confirmedDeleteArticle',
        'cancelledDeleteArticle',
        'deleteSelectedQuery',
        'updateList' => 'render'
    ];


    public function mount()
    {
        if(!auth()->user()->can('admin_symbol_index')) {
            return abort(403);
        }

        $this->search = request()->query('search', $this->search);
    }

    public function clear()
    {
        $this->search = "";
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    public function updatedSelectAll($value)
    {
        if($value) {
            $this->selectedItems = Symbol::pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }

    }

    public function updatedSelectedItems($value)
    {
        if($this->selectAll) {
            $this->selectAll = false;
        }
    }

    public function archiveSelected()
    {
        if(!auth()->user()->can('admin_symbol_delete')) {
            return abort(403);
        }
        $this->confirm(__('bap.are_you_sure'), [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => __('bap.cancel'),
            'onConfirmed' => 'archiveSelectedQuery',
            'onCancelled' => 'cancelledDelete'
        ]);
    }

    public function sortByColumn($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }
    public function render()
    {
        if(!auth()->user()->can('admin_symbol_index')) {
            return abort(403);
        }

        $symbols = Symbol::filter(['search' => $this->search])->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);

        return view('livewire.admin.symbol.index', compact('symbols'))->layout('layouts.admin');
    }
}
