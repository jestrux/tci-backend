<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PierFilter extends Component
{
    public $activeClass;
    public $selected;
    public $field;
    public $value;
    public $comparison;

    public function __construct($field, $value = "", $comparison = "=", $activeClass = 'selected')
    {
        $this->field = $field;
        $this->value = $value;
        $this->comparison = $comparison;
        $this->activeClass = $activeClass;

        $valueComparison = "filters.where$this->field == '$this->value'";
        if(strlen($value) == 0)
            $valueComparison = "!filters.where$this->field";
            
        $this->selected = "{'$this->activeClass': $valueComparison}";
    }

    public function render()
    {
        return view('components.pier.filter');
    }
}
