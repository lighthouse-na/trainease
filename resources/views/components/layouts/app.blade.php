<x-layouts.app.sidebar>
    <flux:main>

        @livewire('customcomponents.toast') <!-- Ensure this line is present -->

        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
