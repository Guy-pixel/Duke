<?php

namespace App\View\Components;

use Illuminate\View\Component;

class mediaBar extends Component
{
    public $spotifyUserId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($spotifyUserId)
    {
        $this->spotifyUserId=$spotifyUserId;
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
