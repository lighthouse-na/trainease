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
    public $divisions = [];


    protected $listeners = [
        'refreshAssessments' => '$refresh',
    ];

    public function mount()
    {
        // Initialize year filters with the current year and past 2 years
        $currentYear = intval(date('Y'));

        // Get divisions with their departments
        $divisions = \App\Models\Organisation\Division::with('department')->get();
        $this->divisions = $divisions->toArray();

        // We still need a flat list of departments for other operations
        $this->departments = Department::all()->toArray();


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
        $this->editingAssessment['department_ids'] = $assessment->getEnrolledDepartmentIds();
        $this->modal('edit-assessment')->show();
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
        $this->modal('edit-assessment')->close();
    }

    private function enrollDepartments($assessmentId, $departmentIds)
    {
        // Get all users in the selected departments
        $users = User::whereHas('user_detail', function ($query) use ($departmentIds) {
            $query->whereIn('department_id', $departmentIds);
        })
            ->pluck('id')
            ->toArray();

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
        return Assessment::paginate(10);
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
        elseif ($now->isAfter($closingDate)) {
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
                    class="w-64 dark:bg-gray-800 dark:text-white" />
                <flux:modal.trigger name="create-assessment">
                    <flux:button variant="primary" icon="plus" class="whitespace-nowrap">
                        {{ __('Create Assessment') }}
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700 overflow-hidden" wire:loading.class="opacity-75">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('Title') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('Year') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('Enrolled Users') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            {{ __('Completion') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($this->assessments as $assessment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700" x-data="{
                            contextMenuOpen: false,
                            contextMenuToggle: function(event) {
                                this.contextMenuOpen = true;
                                event.preventDefault();
                                this.$refs.contextmenu.classList.add('opacity-0');
                                let that = this;
                                $nextTick(function() {
                                    that.calculateContextMenuPosition(event);
                                    that.calculateSubMenuPosition(event);
                                    that.$refs.contextmenu.classList.remove('opacity-0');
                                });
                            },
                            calculateContextMenuPosition(clickEvent) {
                                if (window.innerHeight < clickEvent.clientY + this.$refs.contextmenu.offsetHeight) {
                                    this.$refs.contextmenu.style.top = (window.innerHeight - this.$refs.contextmenu.offsetHeight) + 'px';
                                } else {
                                    this.$refs.contextmenu.style.top = clickEvent.clientY + 'px';
                                }
                                if (window.innerWidth < clickEvent.clientX + this.$refs.contextmenu.offsetWidth) {
                                    this.$refs.contextmenu.style.left = (clickEvent.clientX - this.$refs.contextmenu.offsetWidth) + 'px';
                                } else {
                                    this.$refs.contextmenu.style.left = clickEvent.clientX + 'px';
                                }
                            },
                            calculateSubMenuPosition(clickEvent) {
                                let submenus = document.querySelectorAll('[data-submenu]');
                                let contextMenuWidth = this.$refs.contextmenu.offsetWidth;
                                for (let i = 0; i < submenus.length; i++) {
                                    if (window.innerWidth < (clickEvent.clientX + contextMenuWidth + submenus[i].offsetWidth)) {
                                        submenus[i].classList.add('left-0', '-translate-x-full');
                                        submenus[i].classList.remove('right-0', 'translate-x-full');
                                    } else {
                                        submenus[i].classList.remove('left-0', '-translate-x-full');
                                        submenus[i].classList.add('right-0', 'translate-x-full');
                                    }
                                    if (window.innerHeight < (submenus[i].previousElementSibling.getBoundingClientRect().top + submenus[i].offsetHeight)) {
                                        let heightDifference = (window.innerHeight - submenus[i].previousElementSibling.getBoundingClientRect().top) - submenus[i].offsetHeight;
                                        submenus[i].style.top = heightDifference + 'px';
                                    } else {
                                        submenus[i].style.top = '';
                                    }
                                }
                            }
                        }" x-init="$watch('contextMenuOpen', function(value) {
                            if (value === true) { document.body.classList.add('overflow-hidden') } else { document.body.classList.remove('overflow-hidden') }
                        });
                        window.addEventListener('resize', function(event) { contextMenuOpen = false; });"
                            @contextmenu="contextMenuToggle(event)">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $assessment->assessment_title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">{{ $assessment->closing_date->format('Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">
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
                                    <div class="overflow-hidden h-2 mb-1 text-xs flex rounded bg-gray-200 dark:bg-gray-700">
                                        <div style="width: {{ $percentage }}%"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 dark:bg-blue-600">
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium dark:text-gray-300">{{ $percentage }}%</span>
                                </div>
                            </td>

                            <!-- Context menu for each assessment -->
                            <template x-teleport="body">
                                <div x-show="contextMenuOpen" @click.away="contextMenuOpen=false" x-ref="contextmenu"
                                    class="z-50 min-w-[8rem] text-neutral-800 dark:text-neutral-200 rounded-md border border-neutral-200/70 dark:border-neutral-700 bg-white dark:bg-gray-800 text-sm fixed p-1 shadow-md w-64"
                                    x-cloak>
                                    <div @click="contextMenuOpen=false; $wire.editAssessment({{ $assessment->id }})"
                                        class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 dark:hover:bg-neutral-700 outline-none pl-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2 w-4 h-4"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                        <span>Edit Assessment</span>
                                    </div>
                                    <div @click="contextMenuOpen=false; $wire.deleteAssessment({{ $assessment->id }})"
                                        class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 dark:hover:bg-neutral-700 outline-none pl-8 text-red-600 dark:text-red-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-2 w-4 h-4"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>Delete Assessment</span>
                                    </div>
                                    <div class="h-px my-1 -mx-1 bg-neutral-200 dark:bg-neutral-700"></div>
                                    <div @click="contextMenuOpen=false"
                                        class="relative flex cursor-default select-none group items-center rounded px-2 py-1.5 hover:bg-neutral-100 dark:hover:bg-neutral-700 outline-none pl-8">
                                        <span>Cancel</span>
                                    </div>
                                </div>
                            </template>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                <div class="text-center">
                                    <flux:icon.bolt
                                        class="mx-auto h-16 w-16 text-red-600 bg-red-100 dark:bg-red-900/30 dark:text-red-400 p-3 rounded-full mb-4" />
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-1">{{ __('No assessments found') }}
                                    </h3>
                                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                                        {{ __('Get started by creating your first skill assessment') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                {{ $this->assessments->links() }}
            </div>
        </div>

        <flux:modal name="create-assessment" class="md:w-96 dark:bg-gray-800" variant="flyout" position="right">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg" class="dark:text-white">{{ __('Create Assessment') }}</flux:heading>
                    <flux:subheading class="dark:text-gray-400">{{ __('Fill in the details to create a new assessment.') }}</flux:subheading>
                </div>

                <flux:input wire:model="newAssessment.assessment_title" label="{{ __('Title') }}"
                    placeholder="{{ __('Assessment Title') }}" class="dark:bg-gray-700 dark:text-white" />
                <flux:input wire:model="newAssessment.closing_date" label="{{ __('Closing Date') }}" type="date" class="dark:bg-gray-700 dark:text-white" />

                <flux:checkbox.group wire:model="newAssessment.department_ids" label="{{ __('Departments') }}" class="dark:text-gray-200">
                    @foreach ($divisions as $division)
                        <div class="mb-2">
                            <h3 class="font-medium text-gray-700 dark:text-gray-300">{{ $division['division_name'] }}</h3>
                            <div class="ml-4 mt-1">
                                @foreach ($division['department'] as $department)
                                    <flux:checkbox label="{{ $department['department_name'] }}" value="{{ $department['id'] }}" class="dark:text-gray-300" />
                                @endforeach
                            </div>
                        </div>
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
        <flux:modal name="edit-assessment" class="md:w-96 dark:bg-gray-800" variant="flyout" position="right">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg" class="dark:text-white">{{ __('Edit Assessment') }}</flux:heading>
                    <flux:subheading class="dark:text-gray-400">{{ __('Update the details of the assessment.') }}</flux:subheading>
                </div>

                <flux:input wire:model="editingAssessment.assessment_title" label="{{ __('Title') }}"
                    placeholder="{{ __('Assessment Title') }}" class="dark:bg-gray-700 dark:text-white" />
                <flux:input wire:model="editingAssessment.closing_date" label="{{ __('Closing Date') }}"
                    type="date" class="dark:bg-gray-700 dark:text-white" />

                <flux:checkbox.group wire:model="editingAssessment.department_ids" label="{{ __('Departments') }}" class="dark:text-gray-200">
                    @foreach ($divisions as $division)
                        <div class="mb-2">
                            <h3 class="font-medium text-gray-700 dark:text-gray-300">{{ $division['division_name'] }}</h3>
                            <div class="ml-4 mt-1">
                                @foreach ($division['department'] as $department)
                                    <flux:checkbox label="{{ $department['department_name'] }}" value="{{ $department['id'] }}" class="dark:text-gray-300" />
                                @endforeach
                            </div>
                        </div>
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
