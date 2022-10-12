<?php

namespace App\View\Components;

use Illuminate\View\Component;

class votingCard extends Component
{
    public $song;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($song)
    {
        $this->song=$song;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.voting-card');
    }
}
