<?php

namespace App\Http\Livewire\App\Alert;

use App\Models\AlertSymbol;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Models\Symbol;

class Create extends Component
{
    use LivewireAlert;
    public Symbol $symbol;

    public $more_than;
    public $less_than;
    public $change_percent;
    public $on_time;
    public $hour;
    public $minute;
    public $status;
    public $display_unit;

    public function mount(Symbol $symbol)
    {
        $this->symbol = $symbol;
        $this->less_than = $symbol->price;
        $this->more_than = $symbol->price;
    }

    public function plus_10_less_than()
    {
        $this->less_than = $this->less_than + (0.1) * $this->less_than;
    }


    public function minus_10_more_than()
    {
        $this->less_than = $this->less_than - (0.1) * $this->less_than;
    }

    public function plus_10_more_than()
    {
        $this->more_than = $this->more_than + (0.1) * $this->more_than;
    }


    public function minus_10_less_than()
    {
        $this->more_than = $this->more_than - (0.1) * $this->more_than;
    }


    public function create_alert()
    {
        if(auth()->check()) {
            $this->validate([
                'less_than' => [],
                'more_than' => [],
                'change_percent' => [],
                'hour' => [],
                'minute' => [],
                'display_unit' => [],
                'on_time' => [],
                'status' => []
            ]);

            $alertSymbol = AlertSymbol::firstOrCreate([
                'user_id' => auth()->user()->id,
                'symbol_id' =>  $this->symbol->id
            ]);

            $alertSymbol->less_than = $this->less_than;
            $alertSymbol->more_than = $this->more_than;
            $alertSymbol->change_percent = $this->change_percent;
            $alertSymbol->hour = $this->hour;
            $alertSymbol->minute = $this->minute;
            $alertSymbol->display_unit = $this->display_unit;
            $alertSymbol->on_time = $this->on_time;
            $alertSymbol->status = $this->status;
            $alertSymbol->save();

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
