<?php

use Livewire\Volt\Component;
use App\Models\SkillHarbor\SkillHarborEnrollment;
use App\Models\User;

new class extends Component {
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public $skillharborEnrollment;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function with(): array
    {
        return [
            'submissions' => auth()->user()->supervisedUsers()->paginate(10),
            'enrollmentId' => $this->skillharborEnrollment,
        ];
    }

    public function viewSubmission($id){
        return to_route('skill-harbor.view.submission',['userId' => $id, 'skillharborEnrollment' => $this->skillharborEnrollment]);
    }

};


?>
<x-skillharbor.layout heading="{{ __('Assessment Submissions') }}"
    subheading="{{ __('Review and evaluate assessment submissions from your supervisees.') }}">



    <div class="relative h-auto flex-1 overflow-hidden rounded-lg">
        @if($submissions->count() > 0)
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700">
                <table class="w-full whitespace-nowrap text-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-accent to-accent-content text-white">
                            <th class="px-4 py-3 text-left font-medium">Student</th>
                            <th class="px-4 py-3 text-left font-medium">Submission Date</th>
                            <th class="px-4 py-3 text-left font-medium">Status</th>
                            <th class="px-4 py-3 text-left font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                <td class="px-4 py-3 dark:text-gray-300">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center mr-3">
                                            <flux:avatar name="{{ $submission->name }}" color="auto" color:seed="{{ $submission->id }}"/>
                                        </div>
                                        {{ $submission->name }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 dark:text-gray-300">
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ $submission->getCurrentSkillHarborEnrollment($enrollmentId)->updated_at->format('M d, Y H:i') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 dark:text-gray-300">
                                        @if($submission->getCurrentSkillHarborEnrollment($enrollmentId)->user_status === 1)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400">
                                                Submitted
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800/20 dark:text-yellow-400">
                                                Employee has not submitted
                                            </span>
                                        @endif

                                </td>
                                <td class="px-4 py-3 dark:text-gray-300">
                                    @if($submission->getCurrentSkillHarborEnrollment($enrollmentId)->user_status === 1)
                                        <button wire:click.prevent="viewSubmission({{ $submission->id }})"
                                                class="inline-flex items-center px-3 py-1 text-sm rounded-md bg-accent/10 text-accent hover:bg-accent hover:text-white transition-colors duration-200">
                                            Evaluate
                                        </button>
                                    @else
                                        <button disabled
                                                class="inline-flex items-center px-3 py-1 text-sm rounded-md bg-gray-100 text-gray-400 cursor-not-allowed">
                                            Evaluate
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $submissions->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-sm font-medium text-gray-500 dark:text-gray-400">No submissions found</p>
            </div>
        @endif
    </div>
</x-skillharbor.layout>
