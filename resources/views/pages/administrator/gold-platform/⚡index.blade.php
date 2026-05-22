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
            ->title(__('app.administrator.menu.gold_platforms'));
    }
};
?>

<div>
    <flux:heading size="xl">{{ __('app.administrator.menu.gold_platforms') }}</flux:heading>
</div>