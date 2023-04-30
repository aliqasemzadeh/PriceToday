<?php

namespace App\Http\Livewire\Admin\Symbol;

use App\Models\Symbol;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Edit extends Component
{

    use LivewireAlert;
    public $symbolItem;
    public $symbol;
    public $email;
    public $password;
    public $first_name;
    public $last_name;
    public $title;


    public function mount(Symbol $symbol)
    {
        if(!auth()->user()->can('admin_symbol_edit')) {
            return abort(403);
        }

        $this->symbolItem = $symbol;
        $this->symbol = $symbol->symbol;
        $this->title = $symbol->title;
        $this->coingecko_id = $symbol->coingecko_id;
        $this->coingecko_number = $symbol->coingecko_number;
    }

    public function edit()
    {
        if(!auth()->user()->can('admin_symbol_edit')) {
            return abort(403);
        }

        $this->validate([
            'symbol' => ['required', 'symbol', Rule::unique('symbols')->ignore($this->symbolItem->id)],
            'title' => ['string', 'nullable'],
            'coingecko_id' => ['string', 'nullable'],
            'coingecko_number' => ['number', 'nullable'],
        ]);

        $this->symbolItem->symbol = $this->symbol;
        $this->symbolItem->title = $this->title;
        $this->symbolItem->coingecko_id = $this->coingecko_id;
        $this->symbolItem->coingecko_number = $this->coingecko_number;
        $this->symbolItem->save();


        $this->emitTo(\App\Http\Livewire\Admin\Symbol\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert('success', __('bap.edited'));
    }


    public function render()
    {
        return view('livewire.admin.symbol.edit');
    }
}
