<?php

namespace App\View\Components\User;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Closure;

class Image extends Component
{
    public ?string $userImagePath;
    public string $classes;

    /**
     * Create a new component instance.
     *
     * @param string $class
     */
    public function __construct(string $class = '')
    {
        // Dynamically retrieve the user's image path if authenticated
        $this->userImagePath = $this->getUserImagePath();

        // Use the provided class entirely if supplied, otherwise fallback to default
        $this->classes = $class ?: 'w-20 h-20 rounded-full';
    }

    public function getUserImagePath()
    {   
        if (Auth::check()) {
            // Retrieve the user's image relation (adjust as needed for your structure)
            $userImage = Auth::user()->userImage;


            if ($userImage && $userImage->path) {
                // Retrieve the file path using the userFileImage method
                return Auth::user()->userFileImage($userImage->path);
            }
        }

        // Return null if no user or no image file is found
        return null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user.image', [
            'userImagePath' => $this->userImagePath,
            'classes' => $this->classes,
        ]);
    }
}
