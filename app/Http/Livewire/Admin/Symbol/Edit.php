<?php

namespace App\Http\Livewire\Admin\Symbol;

use App\Models\Symbol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Edit extends Component
{

    use LivewireAlert;
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

        $this->user = $symbol;
        $this->email = $symbol->email;
        $this->first_name = $symbol->first_name;
        $this->last_name = $symbol->last_name;
        $this->title = $symbol->title;
    }

    public function edit()
    {
        if(!auth()->user()->can('admin_symbol_edit')) {
            return abort(403);
        }

        $this->validate([
            'symbol' => ['required', 'symbol', Rule::unique('symbols')->ignore($this->symbol->id)],
            'title' => ['string', 'nullable'],
            'coingecko_id' => ['string', 'nullable'],
            'coingecko_number' => ['number', 'nullable'],
        ]);

        $this->symbol->symbol = $this->symbol;
        $this->symbol->title = $this->title;
        $this->symbol->coingecko_id = $this->coingecko_id;
        $this->symbol->coingecko_number = $this->coingecko_number;
        $this->symbol->save();


        $this->emitTo(\App\Http\Livewire\Admin\Symbol\Index::getName(), 'updateList');
        $this->emit('hideModal');

        $this->alert('success', __('bap.edited'));
    }


    public function render()
    {
        return view('livewire.admin.symbol.edit');
    }
}
