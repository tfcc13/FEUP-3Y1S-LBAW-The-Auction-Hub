<?php

namespace App\View\Components\User;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Closure;

class Image extends Component
{
    private $userImagePath;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
        $this->userImagePath = Auth::check()
            ? optional(Auth::user()->userImage)->path
            : null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.image', [
            'userImagePath' => $this->userImagePath,
        ]);
    }
}
