<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new
#[Layout('layouts::administrator')]
#[Title('app.administrator.menu.gold_platforms')]
class extends Component
{
    //
};
?>

<div>
    <flux:heading size="xl">{{ __('app.administrator.menu.gold_platforms') }}</flux:heading>
</div>