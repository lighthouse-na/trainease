<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Training\SME;
use Illuminate\Support\Facades\Auth;
new class extends Component {
    use WithPagination;
    public $search = '';
    public $showDeleteModal = false;
    public $vendorIdToDelete;
    public $editVendorId;
    public $contactVendorId;
    public $viewVendorId;
    public $meetingVendorId;

    // Form properties for creating/editing a SME vendor
    public $sme_name = '';
    public $sme_email = '';
    public $sme_phone = '';
    public $sme_type = '';
    public $sme_institution = '';
    public $sme_description = '';

    // Contact form properties
    public $contact_subject = '';
    public $contact_message = '';

    // Meeting form properties
    public $meeting_title = '';
    public $meeting_date = '';
    public $meeting_time = '';
    public $meeting_type = '';
    public $meeting_location = '';
    public $meeting_agenda = '';

    // Current vendor for view details modal
    public $currentVendor;

    protected $listeners = ['openModal'];

    public function mount()
    {
        $this->currentVendor = new SME();
    }



    public function confirmDelete($id)
    {
        $this->vendorIdToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function deleteVendor()
    {
        if ($this->vendorIdToDelete) {
            SME::find($this->vendorIdToDelete)->delete();
        }

        $this->showDeleteModal = false;
    }

    public function createVendor()
    {
        $validated = $this->validate([
            'sme_name' => 'required|string|max:255',
            'sme_email' => 'required|email|max:255',
            'sme_phone' => 'nullable|string|max:20',
            'sme_type' => 'required|string|max:255',
            'sme_institution' => 'nullable|string|max:255',
            'sme_description' => 'nullable|string',
        ]);

        SME::create([
            'sme_name' => $this->sme_name,
            'sme_email' => $this->sme_email,
            'sme_phone' => $this->sme_phone,
            'sme_type' => $this->sme_type,
            'sme_institution' => $this->sme_institution,
            'sme_description' => $this->sme_description,
            'consultant_id' => Auth::user()->id,
        ]);

        $this->reset(['sme_name', 'sme_email', 'sme_phone', 'sme_type', 'sme_institution', 'sme_description']);

        // Close the modal
        $this->dispatch('close-modal', ['id' => 'add-sme-vendor']);
    }



    public function with(): array
    {
        return [
            'vendors' => SME::when($this->search, function ($query) {
                return $query->where('sme_name', 'like', '%' . $this->search . '%')->orWhere('sme_email', 'like', '%' . $this->search . '%');
            })->paginate(10),
        ];
    }
}; ?>

<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">SME Vendors</h1>
                <flux:modal.trigger name="add-sme-vendor">
                    <flux:button icon="plus" variant="primary">
                        Add Vendor
                    </flux:button>
                </flux:modal.trigger>
            </div>

            <div class="">
                <div class="p-6 bg-white dark:bg-gray-800 dark:border-gray-700">
                    <div class="mb-4">
                        <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search Vendors..." />
                    </div>

                    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700">
                        <table class="w-full whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-gradient-to-r from-accent to-accent-content text-white">
                                    <th class="px-4 py-3 text-left font-medium rounded-tl-lg">Name</th>
                                    <th class="px-4 py-3 text-left font-medium">Type</th>
                                    <th class="px-4 py-3 text-left font-medium">Company</th>
                                    <th class="px-4 py-3 text-left font-medium">Contact</th>
                                    <th class="px-4 py-3 text-left font-medium rounded-tr-lg">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $groupedVendors = $vendors->groupBy('consultant_id');
                                @endphp

                                @forelse ($groupedVendors as $consultantId => $consultantVendors)
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <td colspan="5" class="px-4 py-2 font-semibold text-gray-700 dark:text-gray-300">
                                            Consultant: {{ \App\Models\User::find($consultantId)->name }}
                                        </td>
                                    </tr>
                                    @foreach ($consultantVendors as $vendor)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700"
                                        x-data="{
                                            contextMenuOpen: false,
                                            vendorId: {{ $vendor->id }},
                                            contextMenuToggle: function(event) {
                                                this.contextMenuOpen = true;
                                                event.preventDefault();
                                                this.$refs.contextmenu.classList.add('opacity-0');
                                                let that = this;
                                                $nextTick(function() {
                                                    that.calculateContextMenuPosition(event);
                                                    that.calculateSubMenuPosition(event);
                                                    that.$refs.contextmenu.classList.remove('opacity-0');
                                                });
                                            },
                                            calculateContextMenuPosition(clickEvent) {
                                                if (window.innerHeight < clickEvent.clientY + this.$refs.contextmenu.offsetHeight) {
                                                    this.$refs.contextmenu.style.top = (window.innerHeight - this.$refs.contextmenu.offsetHeight) + 'px';
                                                } else {
                                                    this.$refs.contextmenu.style.top = clickEvent.clientY + 'px';
                                                }
                                                if (window.innerWidth < clickEvent.clientX + this.$refs.contextmenu.offsetWidth) {
                                                    this.$refs.contextmenu.style.left = (clickEvent.clientX - this.$refs.contextmenu.offsetWidth) + 'px';
                                                } else {
                                                    this.$refs.contextmenu.style.left = clickEvent.clientX + 'px';
                                                }
                                            },
                                            calculateSubMenuPosition(clickEvent) {
                                                let submenus = document.querySelectorAll('[data-submenu]');
                                                let contextMenuWidth = this.$refs.contextmenu.offsetWidth;
                                                for (let i = 0; i < submenus.length; i++) {
                                                    if (window.innerWidth < (clickEvent.clientX + contextMenuWidth + submenus[i].offsetWidth)) {
                                                        submenus[i].classList.add('left-0', '-translate-x-full');
                                                        submenus[i].classList.remove('right-0', 'translate-x-full');
                                                    } else {
                                                        submenus[i].classList.remove('left-0', '-translate-x-full');
                                                        submenus[i].classList.add('right-0', 'translate-x-full');
                                                    }
                                                    if (window.innerHeight < (submenus[i].previousElementSibling.getBoundingClientRect().top + submenus[i].offsetHeight)) {
                                                        let heightDifference = (window.innerHeight - submenus[i].previousElementSibling.getBoundingClientRect().top) - submenus[i].offsetHeight;
                                                        submenus[i].style.top = heightDifference + 'px';
                                                    } else {
                                                        submenus[i].style.top = '';
                                                    }
                                                }
                                            }
                                        }" x-init="$watch('contextMenuOpen', function(value) {
                                            if (value === true) { document.body.classList.add('overflow-hidden') } else { document.body.classList.remove('overflow-hidden') }
                                        });
                                        window.addEventListener('resize', function(event) { contextMenuOpen = false; });"
                                        @contextmenu="contextMenuToggle(event)">
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <flux:avatar name="{{ $vendor->sme_name }}" color="auto"
                                                        color:seed="{{ $vendor->id }}" />
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium dark:text-gray-300">
                                                        {{ $vendor->sme_name }}</div>
                                                    @if ($vendor->sme_description)
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ Str::limit($vendor->sme_description, 30) }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:badge
                                                color="{{ $vendor->sme_type === 'internal' ? 'blue' : 'orange' }}">
                                                {{ $vendor->sme_type }}</flux:badge>

                                        </td>
                                        <td class="px-4 py-3 dark:text-gray-300">{{ $vendor->sme_institution ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="text-sm dark:text-gray-300">{{ $vendor->sme_email }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $vendor->sme_phone ?? 'No phone' }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <flux:button size="xs" variant="ghost" icon="ellipsis-vertical"
                                                @click="contextMenuToggle($event)" />

                                            <template x-teleport="body">

                                                <div x-show="contextMenuOpen" @click.away="contextMenuOpen=false"
                                                    x-ref="contextmenu"
                                                    class="z-50 min-w-[8rem] text-neutral-800 rounded-md border border-neutral-200/70 bg-white text-sm fixed p-1 shadow-md w-64"
                                                    x-cloak>
                                                <flux:modal.trigger name="edit-sme-vendor-{{ $vendor->id }}">

                                                    <div @click="contextMenuOpen=false"
                                                        wire:click="$dispatch('open-modal', { id: 'edit-sme-vendor', data: {{ $vendor->id }} })"
                                                        class="relative flex cursor-pointer select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 outline-none pl-8">
                                                        <span
                                                            class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="w-4 h-4">
                                                                <path
                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                </path>
                                                                <path
                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                        <span>Edit vendor</span>
                                                    </div>
                                                </flux:modal.trigger>

                                                    <flux:modal.trigger name="contact-sme-vendor-{{ $vendor->id }}">

                                                    <div @click="contextMenuOpen=false"
                                                        wire:click="$dispatch('open-modal', { id: 'contact-sme-vendor', data: {{ $vendor->id }} })"
                                                        class="relative flex cursor-pointer select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 outline-none pl-8">
                                                        <span
                                                            class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="w-4 h-4">
                                                                <path
                                                                    d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                                </path>
                                                                <polyline points="22,6 12,13 2,6"></polyline>
                                                            </svg>
                                                        </span>
                                                            <span>Contact</span>
                                                    </div>
                                                </flux:modal.trigger>

                                                    <div class="h-px my-1 -mx-1 bg-neutral-200"></div>

                                                    <div class="relative group">
                                                        <div
                                                            class="flex cursor-default select-none items-center rounded px-2 hover:bg-neutral-100 py-1.5 outline-none pl-8">
                                                            <span
                                                                class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="w-4 h-4">
                                                                    <path
                                                                        d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z">
                                                                    </path>
                                                                    <polyline points="13 2 13 9 20 9"></polyline>
                                                                </svg>
                                                            </span>
                                                            <span>Manage</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="w-4 h-4 ml-auto">
                                                                <polyline points="9 18 15 12 9 6"></polyline>
                                                            </svg>
                                                        </div>
                                                        <div data-submenu
                                                            class="absolute top-0 right-0 invisible mr-1 duration-200 ease-out translate-x-full opacity-0 group-hover:mr-0 group-hover:visible group-hover:opacity-100">
                                                            <div
                                                                class="z-50 min-w-[8rem] overflow-hidden rounded-md border bg-white p-1 shadow-md animate-in slide-in-from-left-1 w-48">
                                                                <div
                                                                    class="relative flex cursor-pointer select-none items-center rounded px-2 py-1.5 hover:bg-neutral-100 text-sm outline-none">
                                                                    <flux:modal.trigger name="view-sme-vendor-details-{{ $vendor->id }}">

                                                                    <span>View details</span>
                                                                    </flux:modal.trigger>
                                                                </div>
                                                                <div @click="contextMenuOpen=false"
                                                                    wire:click="$dispatch('open-modal', { id: 'schedule-meeting', data: {{ $vendor->id }} })"
                                                                    class="relative flex cursor-pointer select-none items-center rounded px-2 py-1.5 hover:bg-neutral-100 text-sm outline-none">
                                                                    <flux:modal.trigger name="schedule-meeting-{{ $vendor->id }}">
                                                                    <span>Schedule meeting</span>
                                                                    </flux:modal.trigger>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="h-px my-1 -mx-1 bg-neutral-200"></div>

                                                    <div @click="contextMenuOpen=false; $wire.confirmDelete(vendorId)"
                                                        class="relative flex cursor-pointer select-none group items-center rounded px-2 py-1.5 hover:bg-red-100 text-red-600 outline-none pl-8">
                                                        <span
                                                            class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="w-4 h-4">
                                                                <path
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                        <span>Delete vendor</span>
                                                    </div>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>



                                    <!-- Delete Confirmation Modal -->
                                    <div x-data="{ open: @entangle('showDeleteModal') }" x-show="open" class="fixed z-50 inset-0 overflow-y-auto"
                                        style="display: none;">
                                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <div x-show="open" x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity"
                                                aria-hidden="true">
                                                <div class="absolute inset-0 bg-black bg-opacity-90"></div>
                                            </div>

                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                            <div x-show="open" x-transition:enter="ease-out duration-300"
                                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave="ease-in duration-200"
                                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>
                                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                                                Delete Vendor
                                                            </h3>
                                                            <div class="mt-2">
                                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                                    Are you sure you want to delete this vendor? This action cannot be undone.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                    <button wire:click="deleteVendor" type="button"
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Delete
                                                    </button>
                                                    <button wire:click="$set('showDeleteModal', false)" type="button"
                                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                            @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                            No vendors found. Add your first vendor to get started.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $vendors->links() }}
                    </div>
                </div>
            </div>


            <flux:modal name="add-sme-vendor" class="md:max-w-xl">
                <form wire:submit="createVendor">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">Add SME Vendor</flux:heading>
                            <flux:text class="mt-2">Enter the details for the new SME vendor.</flux:text>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input wire:model="sme_name" icon="user" label="Name" placeholder="Vendor name" required />
                            <flux:input wire:model="sme_email" icon="envelope" label="Email" type="email"
                                placeholder="vendor@example.com" required />
                            <flux:input mask="(+264) 99 999 9999" icon="phone" wire:model="sme_phone" label="Phone"  placeholder="(+264) 85 999 9999"  />
                            <flux:select wire:model="sme_type" icon="user-group" label="Type" required>
                                <flux:select.option value="" disabled>Select type</flux:select.option>
                                <flux:select.option value="internal">Internal</flux:select.option>
                                <flux:select.option value="external">External</flux:select.option>
                            </flux:select>
                            <flux:input wire:model="sme_institution" icon="building-office" label="Company/Institution"
                                placeholder="Company name" />
                        </div>

                        <flux:textarea wire:model="sme_description" icon="document-text" label="Description"
                            placeholder="Enter details about vendor expertise and background" rows="3" />

                        <div class="flex justify-end space-x-3 pt-4">
                            <flux:button x-on:click="$dispatch('close-modal', { id: 'add-sme-vendor' })">Cancel
                            </flux:button>
                            <flux:button type="submit" variant="primary">Add Vendor</flux:button>
                        </div>
                    </div>
                </form>
            </flux:modal>

            <!-- Edit Vendor Modal -->

                </div>
            </div>
        </div>
    </div>
</div>
