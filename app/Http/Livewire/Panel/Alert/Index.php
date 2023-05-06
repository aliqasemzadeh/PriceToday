<?php

namespace App\Http\Livewire\Panel\Alert;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.panel.alert.index')->layout('layouts.panel');
    }
}
