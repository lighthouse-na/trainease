<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\SkillHarbor\SkillHarborEnrollment;

new class extends Component {
    //
    public $enrollments = [];

    public function mount()
    {
        $this->enrollments = SkillHarborEnrollment::where('user_id', auth()->id())
            ->with(['assessment'])
            ->orderBy('created_at', 'desc')
            ->get();

    }

}; ?>

<div class="flex flex-col items-start w-full">
    @include('partials.skillharbor-heading')

    <x-skillharbor.layout heading="{{ __('My assessments') }}"
                          subheading="{{ __('View and manage your skill assessments') }}">
        <div class="space-y-8 w-full">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-1 border dark:border-gray-700">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-4 sm:px-6 py-4" data-slot="header">
                    <div class="space-y-1 mb-2 sm:mb-0">
                        <h3 class="font-medium text-strong dark:text-white">{{ __('Recent Assessments') }}</h3>
                        <p class="text-default dark:text-gray-300 w-full text-xs text-pretty" data-slot="description">
                            {{ __('View your skill assessments') }}
                        </p>
                    </div>
                </div>

                <div class="divide-default dark:divide-gray-700 bg-white dark:bg-gray-900 divide-y rounded-lg"
                     data-slot="content">
                     @forelse($enrollments as $enrollment)
                     @php
                         $assessment = $enrollment->assessment;
                         $status = match(true) {
                             $enrollment->supervisor_status === 1 => 'view supervisor result',
                             $enrollment->user_status === 1 => 'view submission',
                             default => 'pending',
                         };
                     @endphp

                     <div class="flex flex-col sm:flex-row w-full justify-between p-4 sm:p-6 items-start gap-y-4 sm:gap-x-4 md:gap-x-20" data-slot="field">
                         <div class="space-y-1 w-full sm:w-auto">
                             <h4 class="font-md text-strong dark:text-white break-words">{{ $assessment->assessment_title }}</h4>
                             <p class="text-xs text-weak dark:text-gray-400 mt-1">{{ __('Date') }}: {{ \Carbon\Carbon::parse($assessment->closing_date)->toFormattedDateString() }}</p>
                         </div>
                         <div class="flex items-center self-start sm:self-center">
                            @php
                            $isCompleted = in_array($status, ['view supervisor result', 'view submission']);
                            $variant = $isCompleted ? 'subtle' : 'outline';
                            $colorClass = $isCompleted ? 'text-green-800 dark:text-green-100' : 'text-yellow-800 dark:text-yellow-100';
                            $icon = $isCompleted ? 'check-circle' : 'exclamation-circle'; // Adjust icons based on status
                        @endphp

                        <flux:button
                            type="button"
                            size="sm"
                            variant="{{ $variant }}"
                            icon="{{ $icon }}"
                            href="{{ route('skill-harbor.assessments.hub', $assessment->id) }}"
                            icon:variant="solid"
                            class="px-3 py-1 font-medium whitespace-nowrap {{ $colorClass }}"
                        >
                            {{ $status }}
                        </flux:button>

                         </div>
                     </div>
                 @empty
                     <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                         {{ __('You have not been enrolled in any assessments yet.') }}
                     </div>
                 @endforelse

                </div>
            </div>
        </div>
    </x-skillharbor.layout>
</div>
