<?php

use Livewire\Volt\Component;
use App\Models\SkillHarbor\Qualification;
use Livewire\WithPagination;
new class extends Component {
    use WithPagination;
    public $query = '';
    public $search = '';
    public $qualification = '';
    public $qualificationId = '';
    public function search()
    {
        $this->resetPage();
    }
    public function with(): array
    {
        return [
            'qualifications' => Qualification::where('qualification_title', 'like', '%' . $this->search . '%')->cursorPaginate(10),
        ];
    }

    public function addNewQualification(){
        $this->validate([
            'qualification' => 'required|unique:App\Models\SkillHarbor\Qualification,qualification_title|string|max:255',
        ]);
        Qualification::create([
            'qualification_title' => $this->qualification
        ]);
        $this->qualification = '';

        $this->modal('qualificationModal')->close();

    }

    public function deleteQualification($qualification_id){
        Qualification::find($qualification_id)->delete();
    }
    public function editQualification($qualification_id){
        $qualification = Qualification::find($qualification_id);
        $this->qualification = $qualification->qualification_title;
        $this->qualificationId = $qualification->id;
        $this->modal('qualificationModal')->show();
    }

    public function updateQualification(){
        $this->validate([
            'qualification' => 'required|string|max:255|unique:App\Models\SkillHarbor\Qualification,qualification_title,'.$this->qualificationId,
        ]);

        $qualification = Qualification::find($this->qualificationId);
        $qualification->update([
            'qualification_title' => $this->qualification
        ]);

        $this->qualification = '';
        $this->qualificationId = '';
        $this->modal('qualificationModal')->close();
    }

    public function mount() {}
}; ?>

<div>
    <x-skillharbor.layout heading="{{ __('Qualifications') }}"
        subheading="{{ __('View and manage the system qualifications') }}">
        <div class="flex justify-end  mb-4">
            <flux:input icon="magnifying-glass" placeholder="Search qualifications" />

            <div class="ml-2 justify-end">
                <flux:modal.trigger name="qualificationModal">

                    <flux:button icon="plus">{{ __('Create Qualification') }}</flux:button>
                </flux:modal.trigger>

            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($qualifications as $qualification)
                <div class="flex flex-col items-start justify-between gap-y-3 border rounded-lg p-4" data-slot="field">
                    <div class="flex justify-end items-center gap-4">
                        <h4 class="font-md text-strong">{{ $qualification->qualification_title }}</h4>
                        <div class="flex justify-end items-center gap-2">
                            <flux:button  color="zinc" icon="pencil" size="xs" wire:click="editQualification({{ $qualification->id }})"></flux:button>
                            <flux:button variant="danger" icon="trash" wire:click="deleteQualification({{ $qualification->id }})" size="xs"></flux:button>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $qualifications->links() }}
        </div>
    </x-skillharbor.layout>
    <flux:modal name="qualificationModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Choose A Qualification</flux:heading>
                <flux:subheading>Make sure the title is entered correctly.</flux:subheading>
            </div>


            <flux:input wire:model="qualification" placeholder="Enter Qualification title" label="Qualification title">


            </flux:input>


            <div class="flex">
                <flux:spacer />


                <flux:button wire:click="{{ $qualificationId ? 'updateQualification(' . $qualificationId . ')' : 'addNewQualification' }}" variant="primary">{{ $qualificationId ? 'Update Qualification' : 'Create Qualification' }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
