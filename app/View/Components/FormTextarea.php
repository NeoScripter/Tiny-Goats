<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormTextarea extends Component
{
    public $label;
    public $name;
    public $value;
    public $rows;

    /**
     * Create a new component instance.
     */
    public function __construct($label, $name, $value = null, $rows = 3)
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->rows = $rows;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.admin.form-textarea');
    }
}
