<?php

namespace App\View\Components\Toast;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Confirm extends Component
{
  public string $buttonText;
  public string $route;
  public ?string $method;
  public ?string $id;
  public ?string $modalTitle;
  public ?string $modalMessage;
  public bool $textFlag;
  public string $text;
  public $object;

  public function __construct(
    string $buttonText = 'Confirm',
    string $route,
    string $method,
    string $id,
    string $text = '',
    $object = null,
    string $modalTitle = 'Are you sure?',
    string $modalMessage = 'This action cannot be undone.',
    $textFlag = false,
  ) {
    $this->buttonText = $buttonText;
    $this->route = $route;
    $this->method = $method;
    $this->id = $id;
    $this->modalTitle = $modalTitle;
    $this->modalMessage = $modalMessage;
    $this->textFlag = $textFlag;
    $this->object = $object;
    $this->text = $text;
  }

  public function render(): View|string
  {
    return view('components.toast.confirm');
  }
}
