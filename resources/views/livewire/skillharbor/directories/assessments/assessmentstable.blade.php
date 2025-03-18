<?php

use Livewire\Volt\Component;
use App\Models\SkillHarbor\Assessment;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $statusFilters = ['completed', 'pending', 'overdue'];
    public $yearFilters = [];

    public function mount()
    {
        // Initialize year filters with the current year and past 2 years
        $currentYear = intval(date('Y'));

        $this->yearFilters = [$currentYear, $currentYear - 1, $currentYear - 2];
    }

    public function getAssessmentsProperty()
    {
        return Assessment::search($this->search)
            ->when(count($this->statusFilters) < 3, function($query) {
                // Apply status filters if not all statuses are selected
                // Note: You'll need to adjust this based on your actual status field structure
                $query->whereIn('status', $this->statusFilters);
            })
            ->when(count($this->yearFilters) > 0, function($query) {
                // Apply year filters
                $query->whereYear('closing_date', $this->yearFilters);
            })
            ->orderBy('closing_date', 'desc')
            ->paginate(10);
    }

    public function toggleStatusFilter($status)
    {
        if (in_array($status, $this->statusFilters)) {
            $this->statusFilters = array_diff($this->statusFilters, [$status]);
        } else {
            $this->statusFilters[] = $status;
        }
        $this->resetPage();
    }

    public function toggleYearFilter($year)
    {
        if (in_array($year, $this->yearFilters)) {
            $this->yearFilters = array_diff($this->yearFilters, [$year]);
        } else {
            $this->yearFilters[] = $year;
        }
        $this->resetPage();
    }

    public function getAssessmentStatus($assessment)
    {
        // You'll need to implement logic to determine status
        // This is a placeholder - adjust based on your actual status logic
        return 'pending';
    }
}; ?>

<div>
    <x-skillharbor.layout heading="{{ __('Assessments') }}"
        subheading="{{ __('View and manage the Annual Skill Audit') }}">

        <div class="mb-6 space-y-4">
            <div class="flex flex-row items-center justify-between gap-4">
                <flux:input type="search" wire:model.live.debounce.300ms="search" placeholder="Search assessments..."
                    class="w-64" />
                <flux:button variant="primary" icon="plus" class="whitespace-nowrap">
                    {{ __('Create Assessment') }}
                </flux:button>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <flux:dropdown>
                    <flux:button variant="ghost" icon-trailing="chevron-down">
                        {{ __('Filter by Status') }}
                    </flux:button>

                    <flux:menu class="w-72 p-4">
                        <div class="space-y-2">
                            <flux:menu.checkbox wire:click="toggleStatusFilter('completed')"
                                :checked="in_array('completed', $statusFilters)">
                                {{ __('Completed') }}
                            </flux:menu.checkbox>
                            <flux:menu.checkbox wire:click="toggleStatusFilter('pending')"
                                :checked="in_array('pending', $statusFilters)">
                                {{ __('Pending') }}
                            </flux:menu.checkbox>
                            <flux:menu.checkbox wire:click="toggleStatusFilter('overdue')"
                                :checked="in_array('overdue', $statusFilters)">
                                {{ __('Overdue') }}
                            </flux:menu.checkbox>
                        </div>
                    </flux:menu>
                </flux:dropdown>

                <flux:dropdown>
                    <flux:button variant="ghost" icon-trailing="chevron-down">
                        {{ __('Filter by Year') }}
                    </flux:button>

                    <flux:menu class="w-72 p-4">
                        <div class="space-y-2">
                            @foreach(range(date('Y'), date('Y')-2) as $year)
                                <flux:menu.checkbox wire:click="toggleYearFilter({{ $year }})"
                                    :checked="in_array($year, $yearFilters)">
                                    {{ $year }}
                                </flux:menu.checkbox>
                            @endforeach
                        </div>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </div>

        <div class="bg-white rounded-lg border overflow-hidden" wire:loading.class="opacity-75">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Title') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Year') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Enrolled') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Completion') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($this->assessments as $assessment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $assessment->assessment_title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $assessment->closing_date->format('Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php $status = $this->getAssessmentStatus($assessment) @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $status === 'completed' ? 'bg-green-100 text-green-800' :
                                       ($status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                       'bg-red-100 text-red-800') }}">
                                    {{ __(ucfirst($status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $assessment->enrolled()->count() }} {{ __('Users') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $enrolledCount = $assessment->enrolled()->count();
                                    $submittedCount = $assessment->countSubmittedForReview();
                                    $percentage = $enrolledCount > 0 ? round(($submittedCount / $enrolledCount) * 100) : 0;
                                @endphp
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 mb-1 text-xs flex rounded bg-gray-200">
                                        <div style="width: {{ $percentage }}%"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500">
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium">{{ $percentage }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <flux:button size="xs" variant="secondary" href="{{ route('assessments.show', $assessment) }}">
                                        View
                                    </flux:button>
                                    <flux:button size="xs" variant="secondary" href="{{ route('assessments.edit', $assessment) }}">
                                        Edit
                                    </flux:button>
                                    <flux:button size="xs" variant="danger" wire:click="deleteAssessment({{ $assessment->id }})">
                                        Delete
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                <div class="text-center">
                                    <flux:icon.bolt class="mx-auto h-16 w-16 text-red-600 bg-red-100 p-3 rounded-full mb-4" />
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">{{ __('No assessments found') }}</h3>
                                    <p class="text-gray-500 mb-6">{{ __('Get started by creating your first skill assessment') }}</p>

                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $this->assessments->links() }}
            </div>
        </div>

        <!-- Empty State -->

    </x-skillharbor.layout>
</div>
