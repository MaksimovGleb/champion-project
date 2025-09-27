<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TabPane extends Component
{
    public function __construct(public $id, public $active = '')
    {
        if ($this->active)
            $this->active = 'active';
    }

    public function render()
    {
        return view('components.tab-pane');
    }
}
