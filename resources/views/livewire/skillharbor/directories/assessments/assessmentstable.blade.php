<?php

use Livewire\Volt\Component;
use App\Models\SkillHarbor\Assessment;
use App\Models\Organisation\Department;
use App\Models\User;
use App\Models\SkillHarbor\SkillHarborEnrollment;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $search = '';
    public $statusFilters = ['completed', 'pending', 'overdue'];
    public $yearFilters = [];

    protected $listeners = [
        'refreshAssessments' => '$refresh',
    ];

    public function mount()
    {
        // Initialize year filters with the current year and past 2 years
        $currentYear = intval(date('Y'));
        $this->departments = Department::all()->toArray();

        $this->yearFilters = [$currentYear + 1, $currentYear, $currentYear - 1, $currentYear - 2];
    }

    public $departments = [];
    public $newAssessment = [
        'assessment_title' => '',
        'closing_date' => '',
        'department_ids' => [],
    ];

    public $editingAssessment = [
        'id' => null,
        'assessment_title' => '',
        'closing_date' => '',
        'department_ids' => [],
    ];

    public function createAssessment()
    {
        $this->validate([
            'newAssessment.assessment_title' => 'required|string|max:255',
            'newAssessment.closing_date' => 'required|date|after:today',
            'newAssessment.department_ids' => 'required|array',
            'newAssessment.department_ids.*' => 'exists:departments,id',
        ]);

        // Create the assessment
        $assessment = Assessment::create([
            'assessment_title' => $this->newAssessment['assessment_title'],
            'closing_date' => $this->newAssessment['closing_date'],
        ]);

        // Enroll users in the selected departments
        $this->enrollDepartments($assessment->id, $this->newAssessment['department_ids']);

        $this->reset('newAssessment');
        $this->dispatch('refreshAssessments'); // Refresh the table
        $this->modal('create-assessment')->close();

    }

    public function editAssessment($id)
    {
        $assessment = Assessment::findOrFail($id);
        $this->editingAssessment = $assessment->toArray();
        $this->editingAssessment['department_ids'] = $assessment->departments()->pluck('id')->toArray();
        $this->modal('edit-assessment')->open();
    }

    public function updateAssessment()
    {
        $this->validate([
            'editingAssessment.assessment_title' => 'required|string|max:255',
            'editingAssessment.closing_date' => 'required|date|after:today',
            'editingAssessment.department_ids' => 'required|array',
            'editingAssessment.department_ids.*' => 'exists:departments,id',
        ]);

        $assessment = Assessment::findOrFail($this->editingAssessment['id']);
        $assessment->update([
            'assessment_title' => $this->editingAssessment['assessment_title'],
            'closing_date' => $this->editingAssessment['closing_date'],
        ]);

        // Update department enrollments
        $this->enrollDepartments($assessment->id, $this->editingAssessment['department_ids']);

        $this->reset('editingAssessment');
        $this->dispatch('refreshAssessments'); // Refresh the table
        $this->modal('create-assessmentl')->close();
    }

    private function enrollDepartments($assessmentId, $departmentIds)
    {
        // Get all users in the selected departments
        $userIds = [];
        foreach ($departmentIds as $departmentId) {
            $departmentUsers = User::whereHas('user_detail', function($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
            })->pluck('id')->toArray();
            $userIds = array_merge($userIds, $departmentUsers);
        }
        $users = array_unique($userIds);

        // Get all current enrollments for the assessment
        $existingEnrollments = SkillHarborEnrollment::where('assessment_id', $assessmentId)->pluck('user_id')->toArray();

        // Find users to enroll (in selected departments but not already enrolled)
        $usersToEnroll = array_diff($users, $existingEnrollments);

        // Find users to unenroll (enrolled but no longer in selected departments)
        $usersToUnenroll = array_diff($existingEnrollments, $users);

        // Enroll new users
        foreach ($usersToEnroll as $userId) {
            SkillHarborEnrollment::create([
                'user_id' => $userId,
                'assessment_id' => $assessmentId,
                'user_status' => 0,
                'supervisor_status' => 0,
            ]);
        }

        // Unenroll users no longer in selected departments
        SkillHarborEnrollment::where('assessment_id', $assessmentId)->whereIn('user_id', $usersToUnenroll)->delete();
    }
    public function getAssessmentsProperty()
    {
        return Assessment::search($this->search)
            ->when(count($this->statusFilters) < 3, function ($query) {
                // Apply status filters if not all statuses are selected
                // Note: You'll need to adjust this based on your actual status field structure
                $query->whereIn('status', $this->statusFilters);
            })
            ->when(count($this->yearFilters) > 0, function ($query) {
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
        // Get the current date
        $now = now();
        $closingDate = $assessment->closing_date;

        // Get completion stats
        $enrolledCount = $assessment->enrolled()->count();
        $completedCount = $assessment->countSubmittedForReview();

        // If all users have completed, it's completed
        if ($enrolledCount > 0 && $completedCount >= $enrolledCount) {
            return 'completed';
        }
        // If past closing date but not all completed, it's overdue
        else if ($now->isAfter($closingDate)) {
            return 'overdue';
        }
        // Otherwise it's pending
        else {
            return 'pending';
        }
    }
}; ?>

<div>
    <x-skillharbor.layout heading="{{ __('Assessments') }}"
        subheading="{{ __('View and manage the Annual Skill Audit') }}">

        <div class="mb-6 space-y-4">
            <div class="flex flex-row items-center justify-between gap-4">
                <flux:input type="search" wire:model.live.debounce.300ms="search" placeholder="Search assessments..."
                    class="w-64" />
                <flux:modal.trigger name="create-assessment">
                    <flux:button variant="primary" icon="plus" class="whitespace-nowrap">
                        {{ __('Create Assessment') }}
                    </flux:button>
                </flux:modal.trigger>
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
                            @foreach (range(date('Y')+1, date('Y') - 2) as $year)
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
                            {{ __('Enrolled Users') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Completion') }}</th>

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
                                {{ $assessment->enrolledCount() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $enrolledCount = $assessment->enrolledCount();
                                    $submittedCount = $assessment->countSubmittedForReview();
                                    $percentage =
                                        $enrolledCount > 0 ? round(($submittedCount / $enrolledCount) * 100) : 0;
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

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                <div class="text-center">
                                    <flux:icon.bolt
                                        class="mx-auto h-16 w-16 text-red-600 bg-red-100 p-3 rounded-full mb-4" />
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">{{ __('No assessments found') }}
                                    </h3>
                                    <p class="text-gray-500 mb-6">
                                        {{ __('Get started by creating your first skill assessment') }}</p>

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

        <flux:modal name="create-assessment" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('Create Assessment') }}</flux:heading>
                    <flux:subheading>{{ __('Fill in the details to create a new assessment.') }}</flux:subheading>
                </div>

                <flux:input wire:model="newAssessment.assessment_title" label="{{ __('Title') }}"
                    placeholder="{{ __('Assessment Title') }}" />
                <flux:input wire:model="newAssessment.closing_date" label="{{ __('Closing Date') }}" type="date" />

                <flux:checkbox.group wire:model="newAssessment.department_ids" label="{{ __('Departments') }}">
                    @foreach ($departments as $department)
                        <flux:checkbox label="{{ $department['department_name'] }}" value="{{ $department['id'] }}" />
                    @endforeach
                </flux:checkbox.group>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary" wire:click="createAssessment">
                        {{ __('Create') }}
                    </flux:button>
                </div>
            </div>
        </flux:modal>

        <!-- Edit Assessment Modal -->
        <flux:modal name="edit-assessment" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('Edit Assessment') }}</flux:heading>
                    <flux:subheading>{{ __('Update the details of the assessment.') }}</flux:subheading>
                </div>

                <flux:input wire:model="editingAssessment.assessment_title" label="{{ __('Title') }}"
                    placeholder="{{ __('Assessment Title') }}" />
                <flux:input wire:model="editingAssessment.closing_date" label="{{ __('Closing Date') }}"
                    type="date" />

                <flux:checkbox.group wire:model="editingAssessment.department_ids" label="{{ __('Departments') }}">
                    @foreach ($departments as $department)
                        <flux:checkbox label="{{ $department['department_name'] }}" value="{{ $department['id'] }}" />
                    @endforeach
                </flux:checkbox.group>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="submit" variant="primary" wire:click="updateAssessment">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
            </div>
        </flux:modal>

    </x-skillharbor.layout>

</div>
