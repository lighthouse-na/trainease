<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;
use App\Models\Training\CourseProgress;
use App\Models\Organisation\Department;
use App\Models\Organisation\Division;
use App\Models\Organisation\Organisation;
use App\Models\Training\Reports\Summary;
use App\Models\User;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads; // Required for handling file uploads in Livewire
    /**
     * Course Details Variables
     * Shows course content and instructor details
     */
    public $course;

    /**
     *Course Progress Variables & Functions
     * This is to show the progress of the users in the course based on the filters
     */
    public $departments = [];
    public $divisions = [];
    public $organisations = [];
    public $selectedDepartment = null;
    public $selectedDivision = null;
    public $selectedOrganisation = null;
    public $userProgress = [];
    public $averageDepartmentProgress = 0;
    public $averageDivisionProgress = 0;
    public $averageOrganisationProgress = 0;
    protected $listeners =['updatedSelectedOrganisation', 'updatedSelectedDivision', 'updatedSelectedDepartment','updateTotalCost'];

    public function updatedSelectedorganisation()
    {
        $this->divisions = Division::where('organisation_id', $this->selectedOrganisation)->get();
        $this->selectedDivision = null;
        $this->selectedDepartment = null;
        $this->filter_users();
    }

    public function updatedSelectedDivision()
    {
        $this->departments = Department::where('division_id', $this->selectedDivision)->get();
        $this->selectedDepartment = null;
        $this->filter_users();
    }

    public function updatedSelectedDepartment()
    {
        $this->filter_users();
    }

    public function filter_users()
    {
        $query = User::query();

        if ($this->selectedOrganisation) {
            $query->whereHas('user_detail.division', fn($q) => $q->where('organisation_id', $this->selectedOrganisation));
        }


        $filteredUsers = $query->pluck('id');

        $this->userProgress = CourseProgress::whereIn('user_id', $filteredUsers)->where('course_id', $this->course->id)->with('user.user_detail.department')->get()->unique('user_id');

        $this->userProgress->each(fn($progress) => ($progress->progress_percentage = $progress->user->calculateProgress($this->course->id)));

        $this->calculateAverageProgress($filteredUsers);
    }

    public function calculateAverageProgress($filteredUsers)
    {
        $userIds = $filteredUsers->toArray();
        $this->averageOrganisationProgress = $this->course->avgCourseProgress($userIds);
    }

    /**
     * Training Summary Variables & Functions
     * This is to compile the Annual NTA Claims for training centre
     */

    public $facilitator_cost = 0.00;
    public $assessment_cost = 0.00;
    public $certification_cost = 0.00;
    public $travel_cost = 0.00;
    public $accommodation_cost = 0.00;
    public $other_cost = 0.00;
    public $total_cost = 0.00;
    public $facilitator_invoice;
    public $assessment_invoice;
    public $certification_invoice;
    public $travel_invoice;
    public $accommodation_invoice;
    public $other_invoice;


    public function updateTotalCost()
    {
    $this->total_cost =  $this->facilitator_cost +  $this->assessment_cost +  $this->certification_cost + $this->travel_cost +  $this->accommodation_cost +  $this->other_cost;
    }

    public function storeSummary()
    {
        // Validate the inputs
        $this->validate([
            'facilitator_cost' => 'required|decimal:2|min:0',
            'assessment_cost' => 'required|decimal:2|min:0',
            'certification_cost' => 'required|decimal:2|min:0',
            'travel_cost' => 'required|decimal:2|min:0',
            'accommodation_cost' => 'required|decimal:2|min:0',
            'other_cost' => 'required|decimal:2|min:0',
            'facilitator_invoice' => 'nullable|file|mimes:pdf,jpg,png|max:10240', // Validation for file
            'assessment_invoice' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'certification_invoice' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'travel_invoice' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'accommodation_invoice' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
            'other_invoice' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        ]);

        // Calculate total cost
        $this->total_cost = $this->facilitator_cost + $this->assessment_cost + $this->certification_cost + $this->travel_cost + $this->accommodation_cost + $this->other_cost;

        try {
            // Create or update Summary record
            Summary::updateOrCreate(
                [
                    'course_id' => $this->course->id,
                    'user_id' => $this->course->trainer->id, // Current user (trainer) ID
                ],
                [
                    'facilitator_cost' => $this->facilitator_cost,
                    'assessment_cost' => $this->assessment_cost,
                    'certification_cost' => $this->certification_cost,
                    'travel_cost' => $this->travel_cost,
                    'accommodation_cost' => $this->accommodation_cost,
                    'other_cost' => $this->other_cost,
                    'total_cost' => $this->total_cost,
                    // Only store files if they were uploaded
                    'facilitator_invoice' => $this->facilitator_invoice ? $this->facilitator_invoice->store('invoices', 'public') : null,
                    'assessment_invoice' => $this->assessment_invoice ? $this->assessment_invoice->store('invoices', 'public') : null,
                    'certification_invoice' => $this->certification_invoice ? $this->certification_invoice->store('invoices', 'public') : null,
                    'travel_invoice' => $this->travel_invoice ? $this->travel_invoice->store('invoices', 'public') : null,
                    'accommodation_invoice' => $this->accommodation_invoice ? $this->accommodation_invoice->store('invoices', 'public') : null,
                    'other_invoice' => $this->other_invoice ? $this->other_invoice->store('invoices', 'public') : null,

                ],
            );


            session()->flash('message', 'Training summary costs saved successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save training summary costs: ' . $e->getMessage());
        }
    }

    public function mount($course_id)
    {
        $this->course = Course::find(Hashids::decode($course_id)[0]);
        $this->organisations = Organisation::all();
        $this->divisions = Division::all();
        $this->departments = Department::all();
        $this->filter_users();
        if ($course_id) {
            $costs = $this->course->summary->first();

            if ($costs) {
                $this->facilitator_cost = $costs->facilitator_cost;
                $this->assessment_cost = $costs->assessment_cost;
                $this->certification_cost = $costs->certification_cost;
                $this->travel_cost = $costs->travel_cost;
                $this->accommodation_cost = $costs->accommodation_cost;
                $this->other_cost = $costs->other_cost;
                $this->faciliator_invoice = $costs->facilitator_invoice;
                $this->assessment_invoice = $costs->assessment_invoice;
                $this->certification_invoice = $costs->certification_invoice;
                $this->travel_invoice = $costs->travel_invoice;
                $this->accommodation_invoice = $costs->accommodation_invoice;
                $this->other_invoice = $costs->other_invoice;

            }
        }
        $this->updateTotalCost();
    }
}; ?>

<div>
    <div class="flex h-auto w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items
            -center gap-2 ">
                <flux:heading size="xl">Course Details</flux:heading>
                <flux:icon icon="academic-cap" class="w-8 h-8 text-black dark:text-white" />
            </div>
        </div>
        <div x-data="{ activeTab: 'course-details' }">
            <!-- Tab Navigation -->
            <div class="flex border-b border-gray-200 mb-6">
                <button @click="activeTab = 'course-details'"
                    :class="{
                        'border-primary-500 text-accent-content font-medium': activeTab === 'course-details',
                        'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'course-details'
                    }"
                    class="py-2 px-4 border-b-2 focus:outline-none">
                    Course Details
                </button>
                <button @click="activeTab = 'course-progress'"
                    :class="{
                        'border-primary-500 text-accent-content font-medium': activeTab === 'course-progress',
                        'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'course-progress'
                    }"
                    class="py-2 px-4 border-b-2 focus:outline-none">
                    User Progress
                </button>
                <button @click="activeTab = 'course-summary'"
                    :class="{
                        'border-primary-500 text-accent-content font-medium': activeTab === 'course-summary',
                        'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'course-summary'
                    }"
                    class="py-2 px-4 border-b-2 focus:outline-none">
                    Summary
                </button>
            </div>

            <!-- Tab Content -->
            <div>
                <!-- Course Details Tab -->
                <div x-show="activeTab === 'course-details'" x-transition>
                    <div>
                        <div class="relative rounded-xl w-full h-80 bg-gray-800 dark:bg-gray-700">
                            <img src="{{ asset($course->course_image) }}"
                                class="rounded-xl w-full h-full object-cover opacity-60 dark:opacity-20"
                                alt="{{ $course->title }}">
                            <div class="absolute inset-0 flex flex-col justify-center px-10">
                                <a href="{{ route('dashboard') }}" class="text-gray-200 text-sm mb-3 hover:underline">←
                                    Back to
                                    Dashboard</a>
                                <h1 class="text-white text-4xl font-bold">{{ $course->course_name }}</h1>
                                <p class="text-gray-100 text-lg mt-2">{{ $course->course_description }}</p>
                                <div class="flex justify-end">

                                    <flux:button
                                        class="inline-flex items-center justify-center flex-shrink-0 px-3 py-1 text-xs font-medium transition-colors border rounded-md h-9 hover:bg-gray-50 active:bg-white focus:bg-white focus:outline-none"
                                        variant="primary" wire:click.prevent="" class="cursor-pointer">
                                        Edit Course
                                    </flux:button>

                                </div>

                            </div>


                        </div>

                        <!-- Course Content & Instructor Section -->
                        <div class="grid grid-cols-4 gap-6 p-10">
                            <!-- Course Content -->
                            <div class="col-span-4 dark:bg-gray-800 p-6 rounded-xl  dark:border-gray-700">
                                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Course Content</h2>
                                <div x-data="{ activeAccordion: '' }"
                                    class="relative w-full mx-auto overflow-hidden border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 rounded-xl bg-white dark:bg-gray-800">
                                    @foreach ($course->materials as $index => $chapter)
                                        <div x-data="{ id: 'accordion-{{ $index }}' }" class="cursor-pointer group">
                                            <button @click="activeAccordion = (activeAccordion == id) ? '' : id"
                                                class="flex items-center justify-between w-full p-4 text-left select-none">
                                                <span class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $chapter->material_name }}
                                                </span>
                                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-300 duration-200"
                                                    :class="{ 'rotate-180': activeAccordion == id }" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            <div x-show="activeAccordion == id" x-collapse x-cloak>
                                                <div class="p-4 pt-0 text-gray-700 dark:text-gray-300 opacity-80">
                                                    <p>{{ $chapter->description }}</p>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div x-show="activeTab === 'course-progress'" x-transition>
                    <div class="p-6 bg-white dark:bg-gray-800 rounded-xl">
                        <!-- Filters -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">




                            <div class="bg-white dark:bg-gray-800 p-4 rounded-xl border">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Average Organisation
                                    Progress</h3>
                                <div class="relative w-full bg-gray-200 dark:bg-gray-700 h-3 rounded-full mt-2">
                                    <div class="bg-accent-content h-3 rounded-full"
                                        style="width: {{ $averageOrganisationProgress }}%;"></div>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 mt-2">
                                    {{ round($averageOrganisationProgress, 2) }}%</p>
                            </div>

                        </div>

                        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="organisation"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Organisation</label>
                                <flux:select id="organisation" wire:model.live="selectedOrganisation"
                                    placeholder="All organisations">
                                    <option value="">All organisations</option>
                                    @foreach ($organisations as $organisation)
                                        <option value="{{ $organisation->id }}">{{ $organisation->organisation_name }}
                                        </option>
                                    @endforeach
                                </flux:select>
                            </div>

                            <div>
                                <label for="division"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Division</label>
                                <flux:select id="division" wire:model.live="selectedDivision"
                                    placeholder="All divisions" :disabled="!$selectedOrganisation">
                                    <option value="">All divisions</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                                    @endforeach
                                </flux:select>
                            </div>

                            <div>
                                <label for="department"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Department</label>
                                <flux:select id="department" wire:model.live="selectedDepartment"
                                    placeholder="All departments" :disabled="!$selectedDivision">
                                    <option value="">All departments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </flux:select>
                            </div>
                        </div>

                        <!-- Progress Table -->
                        <div class="overflow-x-auto relative">
                            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                                <thead
                                    class="text-xs uppercase bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                    <tr>
                                        <th scope="col" class="py-3 px-6">User</th>
                                        <th scope="col" class="py-3 px-6">Division</th>
                                        <th scope="col" class="py-3 px-6">Department</th>
                                        <th scope="col" class="py-3 px-6">Status</th>
                                        <th scope="col" class="py-3 px-6">Progress</th>
                                        <th scope="col" class="py-3 px-6">Started</th>
                                        <th scope="col" class="py-3 px-6">Last Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($userProgress as $progress)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="py-4 px-6 font-medium">
                                                {{ $progress->user->name }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $progress->user->user_detail->division->division_name ?? 'N/A' }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $progress->user->user_detail->department->department_name ?? 'N/A' }}
                                            </td>

                                            <td class="py-4 px-6">
                                                @if ($progress->is_completed)
                                                    <span
                                                        class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full text-xs">Completed</span>
                                                @else
                                                    <span
                                                        class="px-2 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 rounded-full text-xs">In
                                                        Progress</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6">
                                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                    <div class="bg-accent-content h-2.5 rounded-full"
                                                        style="width: {{ $progress->progress_percentage }}%"></div>
                                                </div>
                                                <span
                                                    class="text-xs mt-1 block">{{ $progress->progress_percentage ?? 0 }}%</span>
                                            </td>

                                            <td class="py-4 px-6">
                                                {{ $progress->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="py-4 px-6">
                                                {{ $progress->updated_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6"
                                                class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">
                                                No user progress data available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div x-show="activeTab === 'course-summary'" x-transition>
                                    <div wire:model="total_cost" type="text" class="flex justify-end mx-6 bg-gray-100 dark:bg-gray-700 p-4 rounded-xl text-2xl font-bold text-accent-content "
                                    readonly x-data="{ total: @entangle('total_cost') }"
                                    x-text="'N$ ' + total.toLocaleString()" ></div>
                                    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg">

                                        <h2 class="text-xl font-semibold mb-4">Training Cost Form</h2>

                                        <form wire:submit.prevent="storeSummary" class="space-y-4">
                                            @csrf

                                            <!-- Facilitator Cost -->
                                            <flux:field>
                                                <flux:label>Facilitator Cost</flux:label>
                                                <flux:description>Cost for the facilitator.</flux:description>
                                                <flux:input.group>
                                                    <flux:input.group.prefix>N$</flux:input.group.prefix>
                                                    <flux:input wire:model.live="facilitator_cost" type="decimal:2"
                                                        min="0" required />
                                                </flux:input.group>
                                                <flux:error name="facilitator_cost" />
                                                    <flux:input type="file" wire:model="facilitator_invoice"
                                                        label="Invoice for Facilitator Cost" />
                                            </flux:field>

                                            <!-- Assessment Cost -->
                                            <flux:field>
                                                <flux:label>Assessment Cost</flux:label>
                                                <flux:description>Cost for assessments.</flux:description>
                                                <flux:input.group>
                                                    <flux:input.group.prefix>N$</flux:input.group.prefix>
                                                    <flux:input wire:model.live="assessment_cost" type="decimal:2"
                                                        min="0" required />
                                                </flux:input.group>
                                                <flux:error name="assessment_cost" />

                                                    <flux:input type="file" wire:model="assessment_invoice"
                                                        label="Invoice for Assessment Cost" />
                                            </flux:field>

                                            <!-- Certification Cost -->
                                            <flux:field>
                                                <flux:label>Certification Cost</flux:label>
                                                <flux:description>Cost for certification.</flux:description>
                                                <flux:input.group>
                                                    <flux:input.group.prefix>N$</flux:input.group.prefix>
                                                    <flux:input wire:model.live="certification_cost" type="decimal:2"
                                                        min="0" required />
                                                </flux:input.group>
                                                <flux:error name="certification_cost" />
                                                    <flux:input type="file" wire:model="certification_invoice"
                                                        label="Invoice for Certification Cost" />
                                            </flux:field>

                                            <!-- Travel Cost -->
                                            <flux:field>
                                                <flux:label>Travel Cost</flux:label>
                                                <flux:description>Travel expenses.</flux:description>
                                                <flux:input.group>
                                                    <flux:input.group.prefix>N$</flux:input.group.prefix>
                                                    <flux:input wire:model.live="travel_cost" type="decimal:2"
                                                        min="0" required />
                                                </flux:input.group>
                                                <flux:error name="travel_cost" />
                                                    <flux:input type="file" wire:model="travel_invoice"
                                                        label="Invoice for Travel Cost" />
                                            </flux:field>

                                            <!-- Accommodation Cost -->
                                            <flux:field>
                                                <flux:label>Accommodation Cost</flux:label>
                                                <flux:description>Lodging costs.</flux:description>
                                                <flux:input.group>
                                                    <flux:input.group.prefix>N$</flux:input.group.prefix>
                                                    <flux:input wire:model.live="accommodation_cost" type="decimal:2"
                                                        min="0" required />
                                                </flux:input.group>
                                                <flux:error name="accommodation_cost" />
                                                    <flux:input type="file" wire:model="accommodation_invoice"
                                                        label="Invoice for Accommodation Cost" />
                                            </flux:field>

                                            <!-- Other Cost -->
                                            <flux:field>
                                                <flux:label>Other Cost</flux:label>
                                                <flux:description>Any additional costs.</flux:description>
                                                <flux:input.group>
                                                    <flux:input.group.prefix>N$</flux:input.group.prefix>
                                                    <flux:input wire:model.live="other_cost" type="decimal:2"
                                                        min="0" required />
                                                </flux:input.group>
                                                <flux:error name="other_cost" />
                                                    <flux:input type="file" wire:model="other_invoice"
                                                        label="Invoice for Other Cost" />
                                            </flux:field>



                                            <div class="flex items-center gap-4">
                                                <div class="flex items-center justify-end">
                                                    <flux:button variant="primary" type="submit" class="w-full">
                                                        {{ __('Save') }}</flux:button>
                                                </div>
                                                <x-action-message class="me-3" on="user-details-updated">
                                                    {{ __('Saved.') }}
                                                </x-action-message>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>



                        </div>


                    </div>



                </div>
            </div>
        </div>
    </div>
</div>
