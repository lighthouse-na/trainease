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
    public $qualification_level = '';
    public $institution = '';

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
            'qualification_title' => $this->qualification,
            'qualification_level' => $this->qualification_level,
            'institution' => $this->institution
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
            'qualification_title' => $this->qualification,
            'qualification_level' => $this->qualification_level,
            'institution' => $this->institution
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
                    <div x-data="{
                        contextMenuOpen: false,
                        contextMenuToggle: function(event) {
                            this.contextMenuOpen = true;
                            event.preventDefault();
                            this.$refs.contextmenu.classList.add('opacity-0');
                            let that = this;
                            $nextTick(function(){
                                that.calculateContextMenuPosition(event);
                                that.calculateSubMenuPosition(event);
                                that.$refs.contextmenu.classList.remove('opacity-0');
                            });
                        },
                        calculateContextMenuPosition (clickEvent) {
                            if(window.innerHeight < clickEvent.clientY + this.$refs.contextmenu.offsetHeight){
                                this.$refs.contextmenu.style.top = (window.innerHeight - this.$refs.contextmenu.offsetHeight) + 'px';
                            } else {
                                this.$refs.contextmenu.style.top = clickEvent.clientY + 'px';
                            }
                            if(window.innerWidth < clickEvent.clientX + this.$refs.contextmenu.offsetWidth){
                                this.$refs.contextmenu.style.left = (clickEvent.clientX - this.$refs.contextmenu.offsetWidth) + 'px';
                            } else {
                                this.$refs.contextmenu.style.left = clickEvent.clientX + 'px';
                            }
                        },
                        calculateSubMenuPosition (clickEvent) {
                            let submenus = document.querySelectorAll('[data-submenu]');
                            let contextMenuWidth = this.$refs.contextmenu.offsetWidth;
                            for(let i = 0; i < submenus.length; i++){
                                if(window.innerWidth < (clickEvent.clientX + contextMenuWidth + submenus[i].offsetWidth)){
                                    submenus[i].classList.add('left-0', '-translate-x-full');
                                    submenus[i].classList.remove('right-0', 'translate-x-full');
                                } else {
                                    submenus[i].classList.remove('left-0', '-translate-x-full');
                                    submenus[i].classList.add('right-0', 'translate-x-full');
                                }
                                if(window.innerHeight < (submenus[i].previousElementSibling.getBoundingClientRect().top + submenus[i].offsetHeight)){
                                    let heightDifference = (window.innerHeight - submenus[i].previousElementSibling.getBoundingClientRect().top) - submenus[i].offsetHeight;
                                    submenus[i].style.top = heightDifference + 'px';
                                } else {
                                    submenus[i].style.top = '';
                                }
                            }
                        }
                    }"
                    x-init="
                        $watch('contextMenuOpen', function(value){
                            if(value === true){ document.body.classList.add('overflow-hidden') }
                            else { document.body.classList.remove('overflow-hidden') }
                        });
                        window.addEventListener('resize', function(event) { contextMenuOpen = false; });
                    "
                    @contextmenu="contextMenuToggle(event)" class="relative z-50 flex w-full justify-between items-center cursor-pointer hover:bg-gray-100 flex flex-col items-start justify-between gap-y-3 border rounded-lg p-4">



                        <div class="flex flex-col space-y-1 text-sm text-gray-600 w-full">
                            <h4 class="text-lg font-semibold text-gray-800 mb-1">{{ $qualification->qualification_title }}</h4>

                            @if($qualification->institution)
                                <div class="flex items-center">

                                    <span class="font-medium">Institution:</span> <span class="ml-1 line-clamp-1">{{ $qualification->institution }}</span>
                                </div>
                            @endif
                            @if($qualification->qualification_level)
                                <div class="flex justify-end w-full mt-auto">
                                    <span>
                                        @if($qualification->qualification_level == 'Bachelor')
                                            <flux:badge color="blue">{{ $qualification->qualification_level }}</flux:badge>
                                        @elseif($qualification->qualification_level == 'Masters')
                                            <flux:badge color="purple">{{ $qualification->qualification_level }}</flux:badge>
                                        @elseif($qualification->qualification_level == 'PhD')
                                            <flux:badge color="amber">{{ $qualification->qualification_level }}</flux:badge>
                                        @elseif($qualification->qualification_level == 'Diploma')
                                            <flux:badge color="emerald">{{ $qualification->qualification_level }}</flux:badge>
                                        @elseif($qualification->qualification_level == 'Certificate')
                                            <flux:badge color="lime">{{ $qualification->qualification_level }}</flux:badge>
                                        @else
                                            <flux:badge color="gray">{{ $qualification->qualification_level }}</flux:badge>
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>

                        <template x-teleport="body">
                            <div x-show="contextMenuOpen" @click.away="contextMenuOpen=false" x-ref="contextmenu" class="z-50 min-w-[8rem] text-neutral-800 rounded-md border border-neutral-200/70 bg-white text-sm fixed p-1 shadow-md w-64" x-cloak>
                                <div @click="contextMenuOpen=false; $wire.editQualification({{ $qualification->id }})" class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 outline-none pl-8">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2 w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    <span>Edit Qualification</span>
                                </div>
                                <div @click="contextMenuOpen=false; $wire.deleteQualification({{ $qualification->id }})" class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 outline-none pl-8 text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2 w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Delete Qualification</span>
                                </div>
                                <div class="h-px my-1 -mx-1 bg-neutral-200"></div>
                                <div @click="contextMenuOpen=false" class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 outline-none pl-8">
                                    <span>Cancel</span>
                                </div>
                            </div>
                        </template>
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

            <flux:select
                wire:model="qualification_level"
                label="Qualification Level"
                placeholder="Select qualification level">
                <flux:select.option value="">Select a level</flux:select.option>
                <flux:select.option value="Certificate">Certificate</flux:select.option>
                <flux:select.option value="Diploma">Diploma</flux:select.option>
                <flux:select.option value="Bachelor">Bachelor's Degree</flux:select.option>
                <flux:select.option value="Honours">Honours Degree</flux:select.option>
                <flux:select.option value="Postgraduate Diploma">Postgraduate Diploma</flux:select.option>
                <flux:select.option value="Master">Master's Degree</flux:select.option>
                <flux:select.option value="PhD">Doctoral Degree (PhD)</flux:select.option>
            </flux:select>

            <flux:select
                wire:model="institution"
                label="Institution"
                placeholder="Select institution">
                <flux:select.option value="">Select an institution</flux:select.option>
                <flux:select.option value="University of Namibia">University of Namibia</flux:select.option>
                <flux:select.option value="Namibia University of Science and Technology">Namibia University of Science and Technology</flux:select.option>
                <flux:select.option value="International University of Management">International University of Management</flux:select.option>
                <flux:select.option value="Namibian College of Open Learning">Namibian College of Open Learning</flux:select.option>
                <flux:select.option value="Namibia Institute of Mining and Technology">Namibia Institute of Mining and Technology</flux:select.option>
                <flux:select.option value="Vocational Training Centre">Vocational Training Centre</flux:select.option>
                <flux:select.option value="Windhoek Vocational Training Centre">Windhoek Vocational Training Centre</flux:select.option>
                <flux:select.option value="Other">Other</flux:select.option>
            </flux:select>
            <div class="flex">
                <flux:spacer />


                <flux:button wire:click="{{ $qualificationId ? 'updateQualification(' . $qualificationId . ')' : 'addNewQualification' }}" variant="primary">{{ $qualificationId ? 'Update Qualification' : 'Create Qualification' }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
