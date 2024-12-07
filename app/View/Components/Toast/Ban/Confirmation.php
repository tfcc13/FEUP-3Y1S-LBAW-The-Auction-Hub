<?php

namespace App\View\Components\Toast\Ban;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Confirmation extends Component
{
  public ?string $buttonName;
  public string $route;
  public $object;
  

  public function __construct(string $route = '', string $button = 'Ban',$object= null)
  {
    $this->buttonName = $button;
    $this->route = $route ?: '/home';  // Use the provided route or default to '/home'
    $this->object = $object;
    
  }

  public function render(): View|Closure|string
  {
   
    return view('components.toast.ban.confirmation', [
      'buttonName' => $this->buttonName,
      'action' => $this->route,
      'object' => $this->object,
    ]);
  }
}
