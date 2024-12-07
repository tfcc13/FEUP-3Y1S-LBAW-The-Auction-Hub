<?php

namespace App\View\Components\Toast\Delete;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class Confirmation extends Component
{
  public ?string $buttonName;
  public string $action;

  public function __construct(string $route = '', string $button = '')
  {
    $this->buttonName = $button;
    $this->action = $route ?: '/home';  // Use the provided route or default to '/home'
  }

  public function render(): View|Closure|string
  {
    return view('components.toast.delete.confirmation', [
      'buttonName' => $this->buttonName,
      'action' => $this->action,
    ]);
  }
}
