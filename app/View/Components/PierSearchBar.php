<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PierSearchBar extends Component
{
    public $debounce;

    public function __construct($debounce = 300)
    {
        $this->debounce = $debounce;
    }

    public function render()
    {
        return view('components.pier.search-bar');
    }
}
