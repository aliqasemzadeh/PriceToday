<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new
#[Layout('layouts::administrator')]
class extends Component
{
    public function render()
    {
        return $this->view()
            ->title(__('price-today.administrator.menu.dashboard'));
    }
};
?>

<div>
    <flux:heading size="xl">{{ __('price-today.administrator.menu.dashboard') }}</flux:heading>
</div>
