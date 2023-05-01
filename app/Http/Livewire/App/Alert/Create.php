<?php

namespace App\Http\Livewire\App\Alert;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Symbol;

class Create extends Component
{
    use LivewireAlert;
    public Symbol $symbol;
    public function mount(Symbol $symbol)
    {
        $this->symbol = $symbol;
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
        return view('livewire.app.alert.create');
    }
}
