<?php

namespace App\Http\Livewire\Panel\Dashboard;

use App\Models\AlertSymbol;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $alerts = AlertSymbol::where('user_id', auth()->user()->id)->get();
        return view('livewire.panel.dashboard.index', compact('alerts'))->layout('layouts.panel');
    }
}
