<div class="flex items-start max-md:flex-col">
    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <flux:navlist variant="outline">
            <flux:navlist.group heading="Platform" class="grid" >

            <flux:navlist.item href="{{ route('skill-harbor.dashboard') }}"   :current="request()->routeIs('skill-harbor.dashboard')" wire:navigate >{{ __('Dashboard') }}</flux:navlist.item>
            <flux:navlist.item href="{{route('skill-harbor.assessments')}}"  :current="request()->routeIs('skill-harbor.assessments')" wire:navigate>{{__('My Assessments')}}</flux:navlist.item>
            <flux:navlist.item href="{{ route('skill-harbor.supervise') }}"  :current="request()->routeIs('skill-harbor.supervise')" wire:navigate>{{ __('Supervise') }}</flux:navlist.item>

            </flux:navlist.group>
            <flux:navlist.group heading="Directories" expandable>
                <flux:navlist.item href="{{ route('skill-harbor.directories.assessments') }}" wire:navigate :current="request()->routeIs('skill-harbor.directories.assessments')" >Assessments</flux:navlist.item>
                <flux:navlist.item href="{{ route('skill-harbor.directories.jcps') }}" wire:navigate :current="request()->routeIs('skill-harbor.directories.jcps')">Job Competency Profiles</flux:navlist.item>
                <flux:navlist.item href="{{ route('skill-harbor.skills') }}" :current="request()->routeIs('skill-harbor.skills')" >Skills</flux:navlist.item>
                <flux:navlist.item href="{{ route('skill-harbor.qualifications') }}" wire:navigate :current="request()->routeIs('skill-harbor.qualifications')">Qualifications</flux:navlist.item>

            </flux:navlist.group>
        </flux:navlist>

    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full" x-transition>
            {{ $slot }}
        </div>
    </div>
</div>
