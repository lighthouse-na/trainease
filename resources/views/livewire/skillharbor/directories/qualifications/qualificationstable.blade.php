<?php

use Livewire\Volt\Component;
use App\Models\SkillHarbor\Qualification;
use Livewire\WithPagination;
new class extends Component {
    use WithPagination;
    public $query = '';
    public $search = '';
    public function search()
    {
        $this->resetPage();
    }
    public function with(): array
    {
        return [
            'qualifications' => Qualification::where('qualification_title', 'like', '%'.$this->search.'%')->paginate(10),
        ];
    }


    public function mount() {}
}; ?>

<div>
    <x-skillharbor.layout heading="{{ __('Qualifications') }}"
        subheading="{{ __('View and manage the system qualifications') }}">
        <div class="mb-4">
            <input type="text" wire:model="search" placeholder="{{ __('Search qualifications...') }}"
            class="px-4 py-2 border rounded-lg">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($qualifications as $qualification)
            <div class="flex flex-col items-start justify-between gap-y-3 border rounded-lg p-4" data-slot="field">
                <div class="space-y-1">
                <h4 class="font-md text-strong">{{ $qualification->qualification_title }}</h4>
                <p class="text-xs text-weak mt-1">{{ __('Date') }}: {{ $qualification->created_at }}</p>
                </div>
                <div class="flex items">
                <span class="px-3 py-1 text-sm rounded-lg cursor-pointer bg-green-100 text-green-800">
                    {{ __('View Qualification') }}
                </span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $qualifications->links() }}
        </div>
        </div>
    </x-skillharbor.layout>
</div>
