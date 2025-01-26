<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckboxInput extends Component
{
    public $id;
    public $name;
    public $checked;

    /**
     * Create a new component instance.
     *
     * @param string $id
     * @param string $name
     * @param bool   $checked
     */
    public function __construct(string $id, string $name, bool $checked = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.checkbox-input');
    }
}
