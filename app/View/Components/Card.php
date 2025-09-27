<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(public $class = "")
    {
        //
    }

    public function render()
    {
        return view('components.card');
    }
}
