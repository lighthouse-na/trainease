<?php

use Livewire\Volt\Component;
use App\Models\SkillHarbor\Qualification;

new class extends Component {
    //
    public $qualifications = [];
    public $myQualifications = [];
    public $confirmingAddQualification = false;
    public $qualification_id;
    public $qualification_status;
    public $from_date;
    public $end_date;
    public $user;

    public function addMyQualification()
    {
        $this->user->qualifications()->attach($this->qualification_id, [
            'status' => $this->qualification_status,
            'from_date' => $this->from_date,
            'end_date' => $this->end_date,
        ]);
        $this->myQualifications = $this->user->qualifications;
        $this->confirmingAddQualification = false;
        $this->modal('addQualification')->close();
    }

    public function deleteQualification($qualificationId)
    {
        $this->user->qualifications()->detach($qualificationId);
        $this->myQualifications = $this->user->qualifications;
    }

    public function editQualification($qualificationId)
    {
        $qualification = $this->user->qualifications()->where('id', $qualificationId)->first();
        if ($qualification) {
            $this->qualification_id = $qualification->id;
            $this->qualification_status = $qualification->pivot->status;
            $this->from_date = $qualification->pivot->from_date;
            $this->end_date = $qualification->pivot->end_date;
            $this->confirmingAddQualification = true;
            $this->modal('addQualification')->open();
        }
    }

    public function updateQualification()
    {
        $this->user->qualifications()->updateExistingPivot($this->qualification_id, [
            'status' => $this->qualification_status,
            'from_date' => $this->from_date,
            'end_date' => $this->end_date,
        ]);
        $this->myQualifications = $this->user->qualifications;
        $this->confirmingAddQualification = false;
        $this->modal('addQualification')->close();
    }

    public function mount()
    {
        $this->user = auth()->user();
        $this->qualifications = Qualification::all();
        $this->myQualifications = $this->user->qualifications;
    }
}; ?>

<div>
    <div class="">
        <div class="flex justify-between items-center  px-6 py-2">
            <h3 class="text-sm font-medium text-gray-900 dark:text-white">Your Qualifications</h3>
            <flux:modal.trigger name="addQualification">
                <flux:button icon="plus">Add</flux:button>
            </flux:modal.trigger>

        </div>


        <div class="space-y-3 bg-white dark:bg-gray-700 rounded-lg max-h-64 overflow-y-auto p-2">

            @forelse($myQualifications as $qualification)
                <div class="flex justify-between items-center border dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-700 shadow-sm hover:shadow-md dark:shadow-gray-900/30 transition-all duration-200">
                    <div class="flex-grow">
                        <h4 class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $qualification->qualification_title ?? 'Qualification' }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            From: {{ $qualification->pivot->from_date ?? 'N/A' }} - To: {{ $qualification->pivot->end_date ?? 'N/A' }}
                        </p>
                    </div>
                    <span
                        class="px-2.5 py-1 text-xs rounded-full font-medium mx-2 whitespace-nowrap {{ $qualification->pivot->status ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300' }}">
                        {{ $qualification->pivot->status }}
                    </span>
                    <div class="flex space-x-2">
                        <flux:button wire:click="editQualification({{ $qualification->id }})" size="sm" variant="ghost">Edit</flux:button>
                        <flux:button wire:click="deleteQualification({{ $qualification->id }})" size="sm" variant="danger">Delete</flux:button>
                    </div>
                </div>

            @empty
                <div class="text-center py-4 text-gray-500">
                    <div class="flex flex-col items-center py-6 space-y-2">
                        <svg width="128" height="92" viewBox="0 0 156 132" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.00125 80.0312L48.2259 49.1733C66.9076 38.2756 90.0086 38.2756 108.69 49.1733L151.916 80.2229C151.916 80.2229 151.914 78.3984 151.916 84.0312C151.918 89.6685 149.14 95.3066 143.581 98.5493L108.69 118.902C90.0086 129.8 66.9076 129.8 48.2259 118.902L13.335 98.5493C7.77618 95.3066 4.99785 89.6685 5 84.0312C5.00215 78.3984 5.00125 80.0312 5.00125 80.0312Z"
                                fill="#E6E8EB" stroke="#889096"></path>
                            <path
                                d="M13.3369 65.5263L48.2278 45.1733C66.9096 34.2756 90.0106 34.2756 108.692 45.1733L143.583 65.5263C154.697 72.0091 154.697 88.0665 143.583 94.5493L108.692 114.902C90.0106 125.8 66.9096 125.8 48.2278 114.902L13.3369 94.5493C2.22363 88.0665 2.22363 72.0091 13.3369 65.5263Z"
                                fill="white" stroke="#889096"></path>
                            <path
                                d="M17.4609 76.0312L57.2986 50.3814C70.3758 42.7531 86.5465 42.7531 99.6237 50.3814L139.461 76.0312C139.461 76.0312 139.53 76.3099 139.532 80.0312C139.534 83.7562 137.698 87.4819 134.025 89.6245L99.6238 109.692C86.5465 117.32 70.3758 117.32 57.2986 109.692L22.8977 89.6245C19.2245 87.4819 17.3889 83.7562 17.3906 80.0312C17.3924 76.3099 17.4609 76.0312 17.4609 76.0312Z"
                                fill="#E6E8EB" stroke="#889096"></path>
                            <path
                                d="M22.8977 66.4487L57.2986 46.3814C70.3758 38.7531 86.5465 38.7531 99.6237 46.3814L134.025 66.4487C141.367 70.7319 141.367 81.3413 134.025 85.6245L99.6238 105.692C86.5465 113.32 70.3758 113.32 57.2986 105.692L22.8977 85.6245C15.555 81.3413 15.5549 70.7319 22.8977 66.4487Z"
                                fill="white" stroke="#889096"></path>
                            <path
                                d="M29.7773 70.0312L67.879 50.7103C74.4176 46.8961 82.503 46.8961 89.0416 50.7103L127.143 72.0312C127.143 72.0312 127.141 74.2222 127.143 76.0312C127.145 77.8447 126.252 79.6591 124.464 80.7022L89.0416 101.365C82.503 105.18 74.4176 105.18 67.879 101.365L32.4564 80.7022C30.6682 79.6591 29.7752 77.8447 29.7773 76.0312C29.7795 74.2222 29.7773 70.0312 29.7773 70.0312Z"
                                fill="#E6E8EB" stroke="#889096"></path>
                            <path
                                d="M32.4564 67.3734L67.879 46.7103C74.4176 42.8961 82.503 42.8961 89.0416 46.7103L124.464 67.3734C128.036 69.4572 128.036 74.6185 124.464 76.7022L89.0416 97.3654C82.503 101.18 74.4176 101.18 67.879 97.3654L32.4564 76.7022C28.8843 74.6185 28.8843 69.4572 32.4564 67.3734Z"
                                fill="white" stroke="#889096"></path>
                            <path
                                d="M112.87 71.7391V40.6389L116 38.8696V26.3478L80 6L44 26.3478V38.8696L47.1304 40.6389V52.9565V71.7391L58.087 78L80 90.5217L101.913 78L112.87 71.7391Z"
                                fill="white"></path>
                            <path
                                d="M80 59.217L80 90.5213L58.087 77.9996L47.1304 71.7387V52.9561V40.6385V40.4344L58.087 46.6952L80 59.217Z"
                                fill="#DFE3E6"></path>
                            <path
                                d="M112.87 71.7389V40.4346L101.913 46.6954L80 59.2172L80 90.5215L101.913 77.9998L112.87 71.7389Z"
                                fill="#F1F3F5"></path>
                            <path d="M80 59.2172V46.6955L56 33.1303L44 26.3477V38.8694L56 45.652L80 59.2172Z"
                                fill="#E6E8EB"></path>
                            <path
                                d="M80 90.5217L80 59.2174M80 90.5217L58.087 78L47.1304 71.7391V52.9565V40.4348L58.087 46.6957L80 59.2174M80 90.5217L101.913 78L112.87 71.7391V40.4348L101.913 46.6957L80 59.2174M80 59.2174V46.6957M80 59.2174L56 45.6522L44 38.8696V26.3478M80 59.2174L104 45.6522L116 38.8696V26.3478M116 26.3478L80 6L44 26.3478M116 26.3478L104 33.1304L80 46.6957M44 26.3478L56 33.1304L80 46.6957"
                                stroke="#889096"></path>
                            <path
                                d="M56 54.0843C56 52.9332 56.8081 52.4666 57.805 53.0421L67.4318 58.6002C68.4287 59.1757 69.2369 60.5755 69.2369 61.7266C69.2369 62.8777 68.4287 63.3443 67.4318 62.7687L57.805 57.2107C56.8081 56.6351 56 55.2354 56 54.0843Z"
                                fill="#889096"></path>
                            <path
                                d="M104.236 54.0843C104.236 52.9332 103.428 52.4666 102.431 53.0421L92.8045 58.6002C91.8076 59.1757 90.9995 60.5755 90.9995 61.7266C90.9995 62.8777 91.8076 63.3443 92.8045 62.7687L102.431 57.2107C103.428 56.6351 104.236 55.2354 104.236 54.0843Z"
                                fill="#889096"></path>
                        </svg>
                        <div class="text-center">
                            <p class="text-gray-500 text-sm mb-2">No Qualifications Visible</p>
                            <p class="text-xs text-gray-400">Add your qualifications to view them</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <flux:modal name="addQualification" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Add or Edit Qualification</flux:heading>
                <flux:subheading>Fill in the details below to add or update your qualification.</flux:subheading>
            </div>

            <flux:select wire:model.live="qualification_id" placeholder="Choose qualification...">
                @foreach ($this->qualifications as $qualification)
                    <flux:select.option value="{{ $qualification->id }}">{{ $qualification->qualification_title }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:checkbox wire:model="qualification_status" label="I currently hold this qualification" />            <flux:input type="date" label="Start Date" wire:model.live="from_date"></flux:input>
            <flux:input type="date" label="End Date" wire:model.live="end_date"></flux:input>



            <div class="flex">
                <flux:button x-on:click="$flux.modal('addQualification').close()" variant='ghost'>Cancel</flux:button>
                <flux:spacer />
                <flux:button wire:click="addMyQualification" variant="primary">Save</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
