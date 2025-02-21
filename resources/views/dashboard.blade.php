<x-app-layout>
    @role('staff')
    <x-slot name="header">
        <h2 class="font-light text-xs text-gray-400 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Learn Valuable Skills') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                {{-- Display User Content --}}

                    @livewire('staff.staff-dashboard')

            </div>
        </div>
    </div>
    @endrole

    @role('admin')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                {{-- Display User Content --}}
                @livewire('admin.admin-dashboard')
            </div>
        </div>
    </div>
@endrole

@role('trainer')
<div class="m-0">
    <div class="m-0">
        <div class="">
            {{-- Display User Content --}}
            @livewire('trainer.trainer-dashboard')
        </div>
    </div>
</div>
@endrole

</x-app-layout>
