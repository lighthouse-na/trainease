<x-layouts.app>

    <div class="flex h-auto w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2 ">
                <flux:heading size="xl">Dashboard</flux:heading>
                <flux:icon icon="academic-cap" class="w-8 h-8 text-black dark:text-white" />
            </div>


        </div>
        @role('staff')
        <div>
            @livewire('staff.staffdashboard')
        </div>
        @endrole
        @role('trainer')
        <div>
            @livewire('trainer.trainerdashboard')
        </div>
        @endrole


    </div>
</x-layouts.app>
