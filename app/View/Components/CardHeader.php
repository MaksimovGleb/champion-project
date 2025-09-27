<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardHeader extends Component
{
    public function __construct(public $title, public $href, public $ariaExpanded = false)
    {
        //
    }

    public function render()
    {
        return view('components.card-header');
    }
}
