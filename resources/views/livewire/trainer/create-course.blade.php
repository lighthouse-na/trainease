<?php

use App\Models\Training\CourseMaterial;
use App\Models\Training\Quiz\Quiz;
use App\Models\User;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Training\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Training\Quiz\Question;
use App\Models\Training\SME;

new #[Layout('components.layouts.app.header')] class extends Component {
    use WithFileUploads;

    public string $activeTab = 'course';
    public bool $courseCreated = false;
    public ?int $courseId = null;
    public string $existingImage = '';

    // Course properties
    public string $title = '';
    public string $description = '';
    public $courseImage = null;
    public float $course_fee;
    public string $startDate;
    public string $endDate;
    // public string $course_type;
    public string $course_type = 'online';
    public int $userId;
    public $is_stem = false;




    /**
     * @param Course $course
     * @return void
     */
    public function mount(Course $course): void
    {
        if ($course->id) {
            $this->courseId = $course->id;
            $this->courseCreated = true;
            $this->title = $course->course_name;
            $this->description = $course->course_description;
            $this->course_fee = $course->course_fee;
            $this->startDate = $course->start_date->toDateString();
            $this->endDate = $course->end_date->toDateString();
            $this->existingImage = $course->course_image;
            $this->course_type = $course->course_type;
            $this->userId = $course->user_id;
            $this->sme_id = $course->sme_id;


        }
    }

    /**
     * @return void
     */
    public function saveCourse(): void
    {
        // Validate course data
        $this->validate([
            'title' => 'required|min:3',
            'description' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'course_fee' => 'required|numeric|min:0',
            'course_type' => 'required',
            'courseImage' => 'required',
            'is_stem' => 'required|boolean',

        ]);

        // Process image if uploaded
        $imagePath = $this->existingImage;

        if ($this->courseImage) {
            $imagePath = $this->courseImage->store('course-images', 'public');
        }

        // Check if we're updating or creating
        if ($this->courseId) {
            // Update existing course
            $course = Course::findOrFail($this->courseId);
            $course->course_name = $this->title;
            $course->course_description = $this->description;
            $course->start_date = $this->startDate;
            $course->end_date = $this->endDate;
            $course->course_fee = $this->course_fee;
            $course->course_type = $this->course_type;
            $course->is_stem = $this->is_stem;


            if ($imagePath) {
                $course->course_image = $imagePath;
            }
            $course->save();

            session()->flash('message', 'Course updated successfully!');
        } else {
            // Create new course
            $course = Course::create([
                'course_name' => $this->title,
                'course_description' => $this->description,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'course_fee' => $this->course_fee,
                'course_image' => $imagePath,
                'user_id' => Auth::user()->id,
                'course_type' => $this->course_type,
                'is_stem' => $this->is_stem,

            ]);

            $this->courseId = $course->id;
            $this->courseCreated = true;
            $this->existingImage = $imagePath;

            session()->flash('message', 'Course created successfully!');
        }
    }

    public function saveMaterial()
    {
        if (!$this->courseCreated) {
            return;
        }

        // Validate material data
        $this->validate([
            'materialTitle' => 'required|min:3',
            'materialDescription' => 'required',
            'materialContent' => 'required',
        ]);

        // Get the course
        $course = Course::find($this->courseId);

        // Create the material
        $course->materials()->create([
            'material_name' => $this->materialTitle,
            'description' => $this->materialDescription,
            'material_content' => $this->materialContent,
        ]);

        // Reset the form fields
        $this->materialTitle = '';
        $this->materialDescription = '';
        $this->materialContent = '';
        $this->materialFile = null;

        // Refresh the materials list
        $this->courseMaterials = $course->materials;
        $this->modal('materialModal')->close();
    }

    public function editMaterial($materialId)
    {
        if (!$this->courseCreated) {
            return;
        }
        $this->isEditingMaterial = true;
        $this->modal('materialModal')->show();
        // Find the material from the course materials collection
        $material = $this->courseMaterials->find($materialId);

        if ($material) {
            // Populate the form fields with the material data
            $this->materialTitle = $material->material_name;
            $this->materialDescription = $material->description;
            $this->materialContent = $material->material_content;

            // Set active tab to materials to display the edit form
            $this->activeTab = 'materials';

            // Store the material ID for update
            $this->editingMaterialId = $materialId;
        }
    }

    public function deleteMaterial($materialId)
    {
        if (!$this->courseCreated) {
            return;
        }

        // Find the course
        $course = Course::find($this->courseId);

        // Find the material and delete it
        $material = $course->materials()->find($materialId);

        if ($material) {
            $material->delete();

            // Refresh the materials list
            $this->courseMaterials = $course->materials;

            session()->flash('message', 'Course material deleted successfully!');
        }
    }

    public function updateMaterial()
    {
        if (!$this->courseCreated || !$this->editingMaterialId) {
            return;
        }

        // Validate material data
        $this->validate([
            'materialTitle' => 'required|min:3',
            'materialDescription' => 'required',
            'materialContent' => 'required',
        ]);

        // Get the course
        $course = Course::find($this->courseId);

        // Find the material and update it
        $material = $course->materials()->find($this->editingMaterialId);

        if ($material) {
            $material->update([
                'material_name' => $this->materialTitle,
                'description' => $this->materialDescription,
                'material_content' => $this->materialContent,
            ]);

            // Reset form fields
            $this->materialTitle = '';
            $this->materialDescription = '';
            $this->materialContent = '';
            $this->materialFile = null;
            $this->editingMaterialId;
            $this->isEditingMaterial = false;

            // Refresh the materials list
            $this->modal('materialModal')->close();
            $this->courseMaterials = $course->materials;

            session()->flash('message', 'Course material updated successfully!');

        }
    }





    public function setTab($tab)
    {
        // Only allow switching to other tabs if course is created
        if ($tab !== 'course' && !$this->courseCreated) {
            return;
        }

        $this->activeTab = $tab;
    }
}; ?>

<div>

    <div class="p-4 ">
        <h2 class="text-xl font-bold mb-4 dark:text-white">{{ $courseId ? 'Edit Course' : 'Create Course' }}</h2>

        @if (session()->has('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900 dark:text-green-300">
                {{ session('message') }}
            </div>
        @endif

        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                        :class="{
                            'border-accent-content text-accent-content dark:text-accent-content': $wire
                            .activeTab=== 'course',
                            'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:hover:border-gray-500': $wire
                                .activeTab !== 'course'
                        }"
                        wire:click="setTab('course')" type="button" role="tab">Course Details
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                        :class="{

                            'border-accent-content text-accent-content dark:text-accent-content': $wire.activeTab=== 'materials' &&
                                $wire
                                .courseCreated,
                            'border-transparent text-gray-400 dark:text-gray-500 cursor-not-allowed': !$wire
                                .courseCreated,
                            'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:hover:border-gray-500': $wire
                                .activeTab !== 'materials' && $wire.courseCreated
                        }"
                        wire:click="setTab('materials')" type="button" role="tab" :disabled="!$wire.courseCreated"
                        :title="!$wire.courseCreated ? 'Save course details first' : ''">Course Materials
                    </button>
                </li>

                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                        :class="{

                            'border-accent-content text-accent-content dark:text-accent-content': $wire.activeTab=== 'quiz' &&
                                $wire
                                .courseCreated,
                            'border-transparent text-gray-400 dark:text-gray-500 cursor-not-allowed': !$wire
                                .courseCreated,
                            'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:hover:border-gray-500': $wire
                                .activeTab !== 'quiz' && $wire.courseCreated
                        }"
                        wire:click="setTab('quiz')" type="button" role="tab" :disabled="!$wire.courseCreated"
                        :title="!$wire.courseCreated ? 'Save course details first' : ''">Quiz
                    </button>
                </li>
                <li role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                        :class="{

                            'border-accent-content text-accent-content dark:text-accent-content': $wire.activeTab=== 'enrollments' &&
                                $wire
                                .courseCreated,
                            'border-transparent text-gray-400 dark:text-gray-500 cursor-not-allowed': !$wire
                                .courseCreated,
                            'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:hover:border-gray-500': $wire
                                .activeTab !== 'enrollments' && $wire.courseCreated
                        }"
                        wire:click="setTab('enrollments')" type="button" role="tab"
                        :disabled="!$wire.courseCreated"
                        :title="!$wire.courseCreated ? 'Save course details first' : ''">Enrollments
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content">

            <div x-show="$wire.activeTab=== 'course'" class="p-4 rounded-lg bg-white dark:bg-gray-800" x-transition>
                <h3 class="text-lg font-semibold mb-4 dark:text-white">Course Information</h3>
                <form wire:submit.prevent="saveCourse">
                    <div class="mb-4">
                        <flux:input id="title" label="Course Title" wire:model="title" icon="academic-cap"
                            placeholder="Enter course title"
                            class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>
                    <div class="mb-4">
                        <flux:textarea id="description" label="Course Description" wire:model="description"
                            rows="4" icon="document-text" placeholder="Provide a detailed course description"
                            class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>
                    <div class="flex grid grid-cols-2 gap-2 mb-4">
                        <flux:field>
                            <flux:label class="dark:text-gray-300">Course Fee</flux:label>
                            <flux:input.group>
                                <flux:input.group.prefix class="dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    N$
                                </flux:input.group.prefix>

                                <flux:input wire:model="course_fee" type="decimal:2" min="0.00" required
                                    icon="currency-dollar" placeholder="0.00"
                                    class="dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                            </flux:input.group>
                        </flux:field>

                        <flux:field>
                            <flux:label class="dark:text-gray-300">Course Coordinator</flux:label>
                            <flux:select wire:model="sme_id" icon="user-circle" placeholder="Select course coordinator"
                                class="dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <flux:select.option value="">Select a coordinator</flux:select.option>
                                <flux:select.option value="">Me ({{ Auth::user()->name }})</flux:select.option>
                                <optgroup label="Subject Matter Experts">
                                    @foreach (SME::all() as $sme)
                                        <flux:select.option value="{{ $sme->id }}">{{ $sme->sme_name }}
                                        </flux:select.option>
                                    @endforeach
                                </optgroup>
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <flux:label class="dark:text-gray-300">Course Type</flux:label>


                            <flux:select wire:model="course_type" icon="device-tablet"
                                placeholder="Choose course delivery format"
                                class="dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <flux:select.option value="online">Online</flux:select.option>
                                <flux:select.option value="face-to-face">Face to Face</flux:select.option>
                                <flux:select.option value="hybrid">Hybrid</flux:select.option>
                            </flux:select>
                        </flux:field>
                    </div>
                    <div class="mb-4">
                        <flux:input type="file" id="course_image" label="Course Image" wire:model="courseImage"

                            icon="photo" placeholder="Upload course thumbnail"
                            class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" accept="image/*" />

                        <div class="mt-2">
                            <img src="{{ url('storage/' . $existingImage) }}" class="h-24 w-auto object-cover rounded"
                                alt="{{ $existingImage }}">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Current image</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <flux:input label="Start Date" type="date" id="start_date" wire:model="startDate"

                                icon="calendar" placeholder="YYYY-MM-DD"
                                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        </div>
                        <div>
                            <flux:input label="End Date" type="date" id="end_date" wire:model="endDate"

                                icon="calendar" placeholder="YYYY-MM-DD"
                                class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        </div>
                    </div>
                    <flux:button variant="primary" type="submit">
                        {{ $courseId ? 'Update Course' : 'Create Course' }}</flux:button>
                </form>
            </div>

            <div x-show="$wire.activeTab=== 'materials' && $wire.courseCreated"
                class="flex m-0 border h-screen w-full bg-slate-100 dark:bg-slate-900 rounded-l-xl" x-transition>

                @livewire('trainer.components.course-material-editor', [
                    'course' => $courseId,
                ])

            </div>

            <div x-show="$wire.activeTab=== 'quiz' && $wire.courseCreated"
                class="p-4 rounded-lg bg-white dark:bg-gray-800" x-transition>
                @livewire('trainer.components.course-quiz-editor', [
                    'course' => $courseId,
                ])
            </div>

            <div x-show="$wire.activeTab=== 'enrollments' && $wire.courseCreated"
                class="p-4 rounded-lg bg-white dark:bg-gray-800" x-transition>

                @livewire('trainer.components.course-enrollments-editor', [
                    'course' => $courseId,
                ])
            </div>
        </div>
    </div>

<div x-show="$wire.activeTab !== 'course' && !$wire.courseCreated"
class="p-4 rounded-lg bg-white dark:bg-gray-800 text-center" x-transition>
<div class="py-8">
    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
        </path>
    </svg>
    <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">Course details required</h3>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Please complete and save the course details
        first before
        adding materials, quizzes, or enrollments.</p>
    <div class="mt-3">
        <button type="button" wire:click="setTab('course')"
            class="text-sm font-medium text-accent-content hover:text-accent-content dark:text-accent-content">
            Go back to course details <span aria-hidden="true">&rarr;</span>
        </button>
    </div>
</div>

</div>
</div>
