<?php

use Livewire\Volt\Volt;

it('can render', function () {
    $component = Volt::test('trainer.reports.women-in-tech-summary');

    $component->assertSee('');
});
