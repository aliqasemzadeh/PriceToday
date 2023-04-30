<?php

namespace App\Http\Livewire\Admin\Symbol;

use App\Models\Symbol;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;
    public $symbol;
    public $title;
    public $coingecko_id;
    public $coingecko_number;

    public function create()
    {
        if(!auth()->user()->can('admin_symbol_edit')) {
            return abort(403);
        }

        $this->validate([
            'symbol' => ['required', 'symbol', Rule::unique('symbols')],
            'title' => ['string', 'nullable'],
            'coingecko_id' => ['string', 'nullable'],
            'coingecko_number' => ['number', 'nullable'],
        ]);

        $symbol = new Symbol();
        $symbol->symbol = $this->symbol;
        $symbol->title = $this->title;
        $symbol->coingecko_id = $this->coingecko_id;
        $symbol->coingecko_number = $this->coingecko_number;
        $symbol->save();


        $this->emitTo(\App\Http\Livewire\Admin\Symbol\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert('success', __('bap.edited'));
    }

    public function render()
    {
        return view('livewire.admin.symbol.create');
    }
}
