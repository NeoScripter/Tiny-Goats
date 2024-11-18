<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{
    public $label;
    public $name;
    public $value;
    public $type;

    /**
     * Create a new component instance.
     */
    public function __construct($label, $name, $value = null, $type = 'text')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.admin.form-input');
    }
}
