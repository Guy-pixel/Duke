<?php

namespace App\View\Components;

use Illuminate\View\Component;

class mediaBar extends Component
{
    public $spotifyUser;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($spotifyUser)
    {
        $this->spotifyUser=$spotifyUser;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.media-bar');
    }
}
