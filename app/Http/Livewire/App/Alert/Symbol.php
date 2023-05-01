<?php

namespace App\Http\Livewire\App\Alert;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Symbol extends Component
{
    use LivewireAlert;
    public \App\Models\Symbol $symbol;
    public function mount($symbol)
    {
        $this->symbol = \App\Models\Symbol::findOrFail($symbol);
    }

    public function create_alert()
    {
        if(auth()->check()) {
            $this->alert('success', __('bap.added'));
        } else {
            $this->alert('success', __('bap.please_login_first'));
        }
    }

    public function render()
    {
        return view('livewire.app.alert.symbol');
    }
}
