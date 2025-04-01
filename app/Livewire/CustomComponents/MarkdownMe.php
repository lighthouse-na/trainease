<?php

namespace App\Livewire\CustomComponents;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class MarkdownMe extends Component
{
    public $model = '';

    public function render(): View
    {
        return view('livewire.custom-components.markdown-me');
    }
}
