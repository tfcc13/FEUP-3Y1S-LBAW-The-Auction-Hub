<?php

namespace App\View\Components\Toast\Delete;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class Confirmation extends Component
{
  public ?string $buttonName;
  public string $route;
  public $object;
  

  public function __construct(string $route = '', string $button = '',$object= null)
  {
    $this->buttonName = $button;
    $this->route = $route ?: '/home';  // Use the provided route or default to '/home'
    $this->object = $object;
    
  }

  public function render(): View|Closure|string
  {
    
    return view('components.toast.delete.confirmation', [
      'buttonName' => $this->buttonName,
      'action' => $this->route,
      'object' => $this->object,
    ]);
  }
}
