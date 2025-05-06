<?php

use Livewire\Volt\Component;
use App\Models\SkillHarbor\SkillHarborEnrollment;

new class extends Component {
    //
    public $enrollments = [];

    public function mount(){
        $this->enrollments = SkillHarborEnrollment::where('user_id', auth()->id())
            ->with(['assessment'])
            ->orderBy('created_at', 'desc')
            ->get();    }

}; ?>

<div class="flex flex-col items-start">
    @include('partials.skillharbor-heading')

    <x-skillharbor.layout heading="{{ __('Supervise') }}" subheading="{{ __('View and manage your staff skill assessments') }}">
        <div class="space-y-8">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-1 border dark:border-gray-700">
            <div class="flex items-center justify-between px-6 py-4" data-slot="header">
                <div class="space-y-1 ">
                <h3 class="font-medium text-strong dark:text-white">{{ __('Current Assessments') }}</h3>
                <p class="text-default w-full text-xs text-pretty dark:text-gray-300" data-slot="description">
                    {{ __('View your staff skill assessment submissions.') }}
                </p>
                </div>
            </div>

            <div class="divide-default dark:divide-gray-700 bg-white dark:bg-gray-900 divide-y rounded-lg"
                     data-slot="content">
                     @forelse($enrollments as $enrollment)
                     @php
                         $assessment = $enrollment->assessment;

                     @endphp

                     <div class="flex flex-col sm:flex-row w-full justify-between p-4 sm:p-6 items-start gap-y-4 sm:gap-x-4 md:gap-x-20" data-slot="field">
                         <div class="space-y-1 w-full sm:w-auto">
                             <h4 class="font-md text-strong dark:text-white break-words">{{ $assessment->assessment_title }}</h4>
                             <p class="text-xs text-weak dark:text-gray-400 mt-1">{{ __('Date') }}: {{ \Carbon\Carbon::parse($assessment->closing_date)->toFormattedDateString() }}</p>
                         </div>
                         <div class="flex items-center self-start sm:self-center">


                        <flux:button
                            type="button"
                            size="sm"
                            variant="primary"
                            icon="check"
                            href="{{ route('skill-harbor.submissions', $assessment->id) }}"
                            icon:variant="solid"
                        >
                            view submissions
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
    </x-skillharbor.layout>
</div>
