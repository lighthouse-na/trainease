<?php

use Livewire\Volt\Component;

new class extends Component {
    //
    public $search = '';
    public $sortField = 'updated_at';
    public $sortDirection = 'desc';

    public function mount()
    {
        // Initialize the component
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function with(): array
    {
        return [
            'jcps' => \App\Models\SkillHarbor\JobCompetencyProfile::query()
                ->with(['user', 'jcp_skills', 'jcp_qualifications'])
                ->when($this->search, function ($query, $search) {
                    return $query->where('title', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ];
    }
}; ?>

<div>
    <x-skillharbor.layout heading="{{ __('Job Competency Profile') }}"
        subheading="{{ __('View and manage your employee Job Competency Profiles') }}">
        <div class="flex justify-between items-center mb-6">
            <div class="flex space-x-2">
                <flux:input icon="magnifying-glass" placeholder="Search profiles..." />


            </div>
            <flux:button variant="primary" icon="plus">Create Profile</flux:button>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jcps as $jcp)

            @empty
                <div class="col-span-full">

                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $jcps->links() }}
        </div>
    </x-skillharbor.layout>
</div>
