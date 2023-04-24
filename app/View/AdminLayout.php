<?php

namespace App\View\Components;

use Illuminate\View\View;

class AdminLayout
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.admin');
    }
}
