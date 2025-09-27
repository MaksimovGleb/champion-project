<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardBody extends Component
{
    public function __construct(public $id, public $expanded = false)
    {
        if ($this->expanded)
            $this->expanded = "show";
    }

    public function render()
    {
        return view('components.card-body');
    }
}
