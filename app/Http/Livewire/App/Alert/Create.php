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
    public AlertSymbol $alert;

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

        if($alert = AlertSymbol::where(['user_id' => auth()->user()->id, 'symbol_id' =>  $this->symbol->id])->first()) {

            $this->less_than = $alert->less_than;
            $this->more_than = $alert->more_than;
            $this->change_percent = $alert->change_percent;
            $this->hour = $alert->hour;
            $this->minute = $alert->minute;
            $this->display_unit = $alert->display_unit;
            $this->on_time = 'enable';
            $this->status = 'enable';

        } else {
            $this->less_than = $symbol->price;
            $this->more_than = $symbol->price;
        }

    }

    public function plus_less_than($percent = 5)
    {
        $this->less_than = $this->less_than + ($percent / 100) * $this->less_than;
    }

    public function minus_less_than($percent = 5)
    {
        $this->less_than = $this->less_than - ($percent / 100) * $this->less_than;
    }


    public function minus_more_than($percent = 5)
    {
        $this->more_than = $this->more_than - ($percent / 100) * $this->more_than;
    }

    public function plus_more_than($percent = 5)
    {
        $this->more_than = $this->more_than + ($percent / 100) * $this->more_than;
    }

    public function create_alert()
    {
        if(auth()->check()) {
            $this->validate([
                'less_than' => ['lt:more_than','nullable'],
                'more_than' => ['gt:less_than','nullable'],
                'change_percent' => ['nullable'],
                'hour' => ['nullable'],
                'minute' => ['nullable'],
                'display_unit' => ['required'],
                'on_time' => ['nullable'],
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
            if($this->hour && $this->minute) {
                $alertSymbol->on_time = 'enable';
            }
            $alertSymbol->status = 'enable';
            $alertSymbol->save();

            $this->emit('hideModal');

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
