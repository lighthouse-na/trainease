<?php

namespace App\Livewire\CustomComponents;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\Attributes\On;
use Tiptap\Editor;
use Tiptap\Extensions\StarterKit;
use Tiptap\Nodes\CodeBlockHighlight;
use Illuminate\Support\Str;

class MarkdownMe extends Component
{    public $model = '';

    public function render(): View
    {
        return view('livewire.custom-components.markdown-me');
    }
}
