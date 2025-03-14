<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="flex flex-col items-start">
    @include('partials.skillharbor-heading')

    <x-skillharbor.layout heading="{{ __('My assessments') }}" subheading="{{ __('View and manage your skill assessments') }}">
        <div class="space-y-8">
            <div class="bg-gray-100 rounded-xl p-1 border">
            <div class="flex items-center justify-between px-6 py-4" data-slot="header">
                <div class="space-y-1 ">
                <h3 class="font-medium text-strong">{{ __('Recent Assessments') }}</h3>
                <p class="text-default w-full text-xs text-pretty" data-slot="description">
                    {{ __('View your skill assessments') }}
                </p>
                </div>
            </div>

            <div class="divide-default bg-white  divide-y rounded-lg" data-slot="content">
                @foreach([
                ['name' => 'Frontend Development Skills', 'date' => '2023-11-15', 'score' => '85%', 'status' => 'view supervisor result'],
                ['name' => 'Backend PHP Assessment', 'date' => '2023-10-22', 'score' => '78%', 'status' => 'view supervisor result'],
                ['name' => 'DevOps Knowledge Check', 'date' => '2023-12-01', 'score' => '92%', 'status' => 'view submission'],
                ['name' => 'Database Design Skills', 'date' => '2023-12-10', 'score' => 'N/A', 'status' => 'get started'],
                ] as $assessment)
                <div class="flex w-full justify-between p-6 items-start gap-x-20 gap-y-8" data-slot="field">
                    <div class="space-y-1">
                    <h4 class="font-md text-strong">{{ $assessment['name'] }}</h4>
                    <p class="text-xs text-weak mt-1">{{ __('Date') }}: {{ $assessment['date'] }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                    <span class="px-3 py-1 text-sm rounded-lg cursor-pointer {{ ($assessment['status'] === 'view supervisor result' || $assessment['status'] === 'view submission') ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $assessment['status'] }}
                    </span>

                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
    </x-skillharbor.layout>
</div>
