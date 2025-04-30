<?php

use Livewire\Volt\Component;

new class extends Component {
    //
    public string $model;
    public string $placeholder = 'Write your content here...';
}; ?>

<div wire:ignore>
    <textarea
        x-data="markdownEditor('{{ $model }}', '{{ $placeholder }}')"
        x-init="init()"
        class=""></textarea>
</div>
