<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="flex flex-col items-start">
    @include('partials.skillharbor-heading')

    <x-skillharbor.layout heading="{{ __('My assessments') }}" subheading="{{ __('View and manage your skill assessments') }}">
        <div class="space-y-8">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-1 border dark:border-gray-700">
            <div class="flex items-center justify-between px-6 py-4" data-slot="header">
                <div class="space-y-1">
                <h3 class="font-medium text-strong dark:text-white">{{ __('Recent Assessments') }}</h3>
                <p class="text-default dark:text-gray-300 w-full text-xs text-pretty" data-slot="description">
                    {{ __('View your skill assessments') }}
                </p>
                </div>
            </div>

            <div class="divide-default dark:divide-gray-700 bg-white dark:bg-gray-900 divide-y rounded-lg" data-slot="content">
                @foreach([
                ['name' => 'Frontend Development Skills', 'date' => '2023-11-15', 'score' => '85%', 'status' => 'view supervisor result'],

                ] as $assessment)
                <div class="flex w-full justify-between p-6 items-start gap-x-20 gap-y-8" data-slot="field">
                    <div class="space-y-1">
                    <h4 class="font-md text-strong dark:text-white">{{ $assessment['name'] }}</h4>
                    <p class="text-xs text-weak dark:text-gray-400 mt-1">{{ __('Date') }}: {{ $assessment['date'] }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                    <span class="px-3 py-1 text-sm rounded-lg cursor-pointer {{ ($assessment['status'] === 'view supervisor result' || $assessment['status'] === 'view submission') ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' }}">
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
