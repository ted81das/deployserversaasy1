<?php

namespace App\View\Components\Filament\Plans;

use Illuminate\Contracts\View\View;

class All extends \App\View\Components\Plans\All
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|\Closure|string
    {
        return view('components.filament.plans.all', $this->calculateViewData());
    }
}
