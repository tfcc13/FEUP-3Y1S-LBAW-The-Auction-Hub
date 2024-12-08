<?php

namespace App\View\Components\Toast\Put;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class Confirmation extends Component
{
  public ?string $buttonName;
  public string $route;
  public $object;
  public string $idName;

  public function __construct(string $route = '', string $button = 'Ban', $object = null, $id = '')
  {
    $this->buttonName = $button;
    $this->route = $route ?: '/home';  // Use the provided route or default to '/home'
    $this->object = $object;
    $this->idName = $id;
  }

  public function render(): View|Closure|string
  {
    return view('components.toast.put.confirmation', [
      'buttonName' => $this->buttonName,
      'action' => $this->route,
      'object' => $this->object,
      'idName' => $this->idName,
    ]);
  }
}
