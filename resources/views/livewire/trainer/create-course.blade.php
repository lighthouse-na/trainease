<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\Training\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Training\Quiz\Question;

new class extends Component {
    use WithFileUploads;

    public string $activeTab = 'course';
    public bool $courseCreated = false;
    public int $courseId;
    public string $existingImage;

    // Course properties
    public string $title = '';
    public string $description = '';
    public string $courseImage;
    public int $course_fee;
    public Carbon $startDate;
    public Carbon $endDate;
    public string $course_type;
    public int $userId;

    // Materials properties
    /**
     * @var array<int, \App\Models\Training\CourseMaterial> $courseMaterials
     * @var array<int, \App\Models\Training\Quiz\Quiz> $quizes
     * @var array<int, Question> $questions
     * @var array<int, \App\Models\User> $selectedStudents
     */
    public array $courseMaterials = [];
    public string $materialTitle = '';
    public string $materialDescription = '';
    public string $materialContent = '';
    public string $materialFile;
    public int $editingMaterialId;
    public bool $isEditingMaterial = false;

    // Quiz properties
    public array $quizzes;
    public string $quizTitle = '';
    public array $questions = [];
    public int $quizAttempts;
    public int $passingScore;

    // Enrollment properties
    public string $studentSearch = '';
    public array $selectedStudents = [];

    /**
     * @param Course $course
     * @return void
     */
    public function mount(Course $course): void
    {
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

            $this->courseMaterials = $course->materials;
            // Load quizzes with their questions and options
            $this->quizzes = $course
                ->quizes()
                ->with(['questions.options'])
                ->get();

            // If there are quizzes, set up the first one
            if ($this->quizzes->isNotEmpty()) {
                $this->quiz = $this->quizzes->first();
                $this->quizTitle = $this->quiz->title;
                $this->quizAttempts = $this->quiz->max_attempts;
                $this->passingScore = $this->quiz->passing_score;

                // Setup questions array for the form
                $this->questions = $this->quiz->questions
                    ->map(function ($question) {
                        $questionData = [
                            'id' => $question->id,
                            'text' => $question->question_text,
                            'question_type' => $question->question_type,
                            'options' => [],
                        ];

                        // Setup options for each question
                        foreach ($question->options as $index => $option) {
                            $questionData['options'][$index] = $option->option_text;
                            if ($option->is_correct) {
                                $questionData['correct_answer'] = $index;
                            }
                        }

                        return $questionData;
                    })
                    ->toArray();

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
            'courseImage' => 'required'
        ]);

        // Process image if uploaded
        $imagePath = $this->existingImage;
        if ($this->courseImage)) {
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
            $this->editingMaterialId = null;
            $this->isEditingMaterial = false;

            // Refresh the materials list
            $this->modal('materialModal')->close();
            $this->courseMaterials = $course->materials;

            session()->flash('message', 'Course material updated successfully!');
        }
    }

    public function addQuestion()
    {
        if (!$this->courseCreated) {
            return;
        }

        $this->questions[] = [
            'text' => '',
            'question_type' => 'multiple_choice',
            'options' => ['', '', '', ''],
            'correct_answer' => null,
        ];
    }

    public function removeQuestion($index)
    {
        if (isset($this->questions[$index])) {
            // Check if this question exists in database (has an ID)
            if (isset($this->questions[$index]['id'])) {
                $questionId = $this->questions[$index]['id'];

                // Find and delete the question from database
                $question = Question::find($questionId);
                if ($question) {
                    // Delete all associated options first
                    $question->options()->delete();
                    // Delete the question itself
                    $question->delete();
                }
            }

            // Remove from local array
            array_splice($this->questions, $index, 1);
        }
    }
    public function saveQuiz()
    {
        if (!$this->courseCreated) {
            return;
        }

        $this->validate(
            [
                'quizTitle' => 'required|min:3',
                'quizAttempts' => 'required|numeric|min:1',
                'questions' => 'required|array|min:1',
                'questions.*.text' => 'required',
                'questions.*.correct_answer' => 'required',
            ],
            [
                'questions.*.text.required' => 'Question text is required',
                'questions.*.correct_answer.required' => 'You must select a correct answer',
            ],
        );

        $course = Course::find($this->courseId);

        // Check if we already have quizzes for this course
        if ($this->quizzes && $this->quizzes->isNotEmpty()) {
            // Update the existing quiz
            $quiz = $this->quizzes->first();
            $quiz->title = $this->quizTitle;
            $quiz->max_attempts = $this->quizAttempts;
            $quiz->passing_score = $this->passingScore;
            $quiz->save();
        } else {
            // Create a new quiz
            $quiz = $course->quizes()->create([
                'title' => $this->quizTitle,
                'quizAttempts' => $this->quizAttempts,
                'passingScore' => $this->passingScore,
            ]);
        }

        // Process each question
        foreach ($this->questions as $index => $questionData) {
            // Check if we're updating an existing question or creating a new one
            $questionId = $questionData['id'] ?? null;

            // Create or update the question
            $question = $quiz->questions()->updateOrCreate(
                ['id' => $questionId],
                [
                    'question_text' => $questionData['text'],
                    'question_type' => $questionData['question_type'] ?? 'multiple_choice',
                    'order' => $index + 1,
                ],
            );

            // Delete existing options for this question if it's being updated
            if ($questionId) {
                $question->options()->delete();
            }

            // Add options
            foreach ($questionData['options'] as $optionIndex => $optionText) {
                if (!empty($optionText)) {
                    $question->options()->create([
                        'option_text' => $optionText,
                        'is_correct' => $questionData['correct_answer'] == $optionIndex,
                        'order' => $optionIndex + 1,
                    ]);
                }
            }
        }

        // Refresh the data
        $this->quizzes = $course
            ->quizes()
            ->with(['questions.options'])
            ->get();

        // Update the quiz property to the current quiz
        if ($this->quizzes->isNotEmpty()) {
            $this->quiz = $this->quizzes->first();
        }

        session()->flash('message', 'Quiz saved successfully!');
    }

    public function enrollStudents()
    {
        if (!$this->courseCreated) {
            return;
        }
        // Student enrollment logic here
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
    <div class="p-6 ">
        <h2 class="text-2xl font-bold mb-6 dark:text-white">{{ $courseId ? 'Edit Course' : 'Create Course' }}</h2>

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
                                .activeTab === 'course',
                            'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:hover:border-gray-500': $wire
                                .activeTab !== 'course'
                        }"
                        wire:click="setTab('course')" type="button" role="tab">Course Details</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                        :class="{
                            'border-accent-content text-accent-content dark:text-accent-content': $wire.activeTab === 'materials' && $wire
                                .courseCreated,
                            'border-transparent text-gray-400 dark:text-gray-500 cursor-not-allowed': !$wire.courseCreated,
                            'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:hover:border-gray-500': $wire
                                .activeTab !== 'materials' && $wire.courseCreated
                        }"
                        wire:click="setTab('materials')" type="button" role="tab" :disabled="!$wire.courseCreated"
                        :title="!$wire.courseCreated ? 'Save course details first' : ''">Course Materials</button>
                </li>

                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                        :class="{
                            'border-accent-content text-accent-content dark:text-accent-content': $wire.activeTab === 'quiz' && $wire
                                .courseCreated,
                            'border-transparent text-gray-400 dark:text-gray-500 cursor-not-allowed': !$wire.courseCreated,
                            'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:hover:border-gray-500': $wire
                                .activeTab !== 'quiz' && $wire.courseCreated
                        }"
                        wire:click="setTab('quiz')" type="button" role="tab" :disabled="!$wire.courseCreated"
                        :title="!$wire.courseCreated ? 'Save course details first' : ''">Quiz</button>
                </li>
                <li role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg"
                        :class="{
                            'border-accent-content text-accent-content dark:text-accent-content': $wire.activeTab === 'enrollments' && $wire
                                .courseCreated,
                            'border-transparent text-gray-400 dark:text-gray-500 cursor-not-allowed': !$wire.courseCreated,
                            'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 dark:hover:border-gray-500': $wire
                                .activeTab !== 'enrollments' && $wire.courseCreated
                        }"
                        wire:click="setTab('enrollments')" type="button" role="tab"
                        :disabled="!$wire.courseCreated"
                        :title="!$wire.courseCreated ? 'Save course details first' : ''">Enrollments</button>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div x-show="$wire.activeTab === 'course'" class="p-4 rounded-lg bg-white dark:bg-gray-800" x-transition>
                <h3 class="text-lg font-semibold mb-4 dark:text-white">Course Information</h3>
                <form wire:click.prevent="saveCourse">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="title">Course Title</label>
                        <input id="title" wire:model="title" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                            for="description">Description</label>
                        <textarea id="description" wire:model="description" rows="4" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>
                    <div class="flex grid grid-cols-2 gap-2 mb-4">
                        <flux:field>
                            <flux:label class="dark:text-gray-300">Course Fee</flux:label>
                            <flux:input.group>
                                <flux:input.group.prefix class="dark:bg-gray-700 dark:border-gray-600 dark:text-white">N$</flux:input.group.prefix>
                                <flux:input wire:model.live="course_fee" type="decimal:2" min="0" required class="dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                            </flux:input.group>
                        </flux:field>

                    <flux:field>
                        <flux:label class="dark:text-gray-300">Course Type</flux:label>

                        <flux:select wire:model.live="course_type" class="dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <flux:select.option value="online">Online</flux:select.option>
                            <flux:select.option value="face-to-face">Face to Face</flux:select.option>
                            <flux:select.option value="hybrid">Hybrid</flux:select.option>
                        </flux:select>
                    </flux:field>
                </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="course_image">Course
                            Image</label>
                        <input type="file" id="course_image" wire:model="courseImage" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            accept="image/*" />

                            <div class="mt-2">
                                <img src="{{ url('storage/' . $existingImage) }}"
                                    class="h-24 w-auto object-cover rounded" alt="{{ $existingImage }}">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Current image</p>
                            </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="start_date">Start
                                Date</label>
                            <input type="date" id="start_date" wire:model="startDate" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="end_date">End Date</label>
                            <input type="date" id="end_date" wire:model="endDate" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        </div>
                    </div>
                    <flux:button variant="primary" type="submit">
                        {{ $courseId ? 'Update Course' : 'Create Course' }}</flux:button>


            </form>
        </div>

        <div x-show="$wire.activeTab === 'materials' && $wire.courseCreated" class="p-4 rounded-lg bg-white dark:bg-gray-800"
            x-transition>
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Course Materials</h3>
            <div class="my-6">
                <div class="border rounded-md divide-y dark:border-gray-700 dark:divide-gray-700">
                    <div class="p-4 flex items-center justify-between">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 w-full">

                            @forelse ($courseMaterials as $material)
                                <div class="bg-white dark:bg-gray-700 border rounded-lg p-4 dark:border-gray-600">
                                    <h5 class="font-semibold text-lg mb-1 truncate dark:text-white">{{ $material->material_name }}
                                    </h5>
                                    <p class="text-gray-500 dark:text-gray-300 text-sm mb-3 line-clamp-2">{{ $material->description }}
                                    </p>
                                    <div class="flex justify-start space-x-2 items-center">
                                        <flux:button wire:click="editMaterial({{ $material->id }})" variant="primary"
                                                     size="xs" outline>
                                            Edit
                                        </flux:button>
                                        <flux:button wire:click="deleteMaterial({{ $material->id }})"
                                                     variant="danger" size="xs" outline>
                                            Delete
                                        </flux:button>
                                        <span
                                            class="text-xs text-gray-400 dark:text-gray-500 justify-end">{{ $material->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>

                            @empty
                                <div class="p-4 flex items-center justify-between">
                                    <div>
                                        <p class="font-medium dark:text-gray-300">No materials added yet</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <flux:modal name="materialModal" variant="flyout" position="right" dismissible="true" wire:model="isModalOpen" class="">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        {{ isset($editingMaterialId) ? 'Edit Material' : 'Add Material' }}
                    </h2>

                    <form wire:submit.prevent="{{ isset($editingMaterialId) ? 'updateMaterial' : 'saveMaterial' }}">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="materialTitle">Material Title</label>
                            <x-input id="materialTitle" wire:model="materialTitle" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="materialDescription">Material Description</label>
                            <x-textarea id="materialDescription" wire:model="materialDescription" rows="3" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="materialContent">Content</label>
                            <x-textarea id="materialContent" wire:model="materialContent" rows="6" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                            <livewire:custom-components.markdown-me wire:model="content" />
                        </div>

                        <div class="flex justify-between items-center">
                            <x-button type="submit" class="bg-accent-content hover:bg-accent-content">
                                {{ isset($editingMaterialId) ? 'Update Material' : 'Add Material' }}
                            </x-button>

                            @if (isset($editingMaterialId))
                                <button type="button" wire:click="$set('editingMaterialId', null)" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                    Cancel Edit
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </flux:modal>

            <flux:modal.trigger name="materialModal">
                <x-button class="bg-primary hover:bg-primary-dark">Create Course Material</x-button>
            </flux:modal.trigger>



        </div>

        <div x-show="$wire.activeTab === 'quiz' && $wire.courseCreated" class="p-4 rounded-lg bg-white dark:bg-gray-800" x-transition>
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Course Quiz</h3>
            <form wire:submit.prevent="saveQuiz">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="quizTitle">Quiz Title</label>
                    <x-input id="quizTitle" wire:model="quizTitle" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="quizAttempts">Maximum
                            Attempts</label>
                        <x-input id="quizAttempts" wire:model="quizAttempts" type="number" min="1"
                            class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="passingScore">Passing Score
                            (%)</label>
                        <x-input id="passingScore" wire:model="passingScore" type="number" min="0"
                            max="100" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Questions</label>

                    @foreach ($questions as $index => $question)
                        <div class="p-4 border rounded-md mb-3 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question
                                    {{ $index + 1 }}</label>
                                <x-input wire:model="questions.{{ $index }}.text" class="w-full dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                    placeholder="Enter question" />
                            </div>

                            <div class="mb-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Options</label>
                                @foreach (['A', 'B', 'C', 'D'] as $optionIndex => $optionLabel)
                                    <div class="flex items-center mb-2">
                                        <div class="mr-2 dark:text-white">{{ $optionLabel }}.</div>
                                        <x-input
                                            wire:model="questions.{{ $index }}.options.{{ $optionIndex }}"
                                            class="w-full dark:bg-gray-800 dark:border-gray-600 dark:text-white" placeholder="Option {{ $optionLabel }}" />
                                        <label class="inline-flex items-center ml-2">
                                            <input type="radio"
                                                wire:model="questions.{{ $index }}.correct_answer"
                                                value="{{ $optionIndex }}"
                                                class="form-radio h-4 w-4 text-accent-content dark:bg-gray-800 dark:border-gray-600">
                                            <span class="ml-1 text-sm text-gray-700 dark:text-gray-300">Correct</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" wire:click="removeQuestion({{ $index }})"
                                class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Remove Question</button>
                        </div>
                    @endforeach

                    <button type="button" wire:click="addQuestion"
                        class="inline-flex items-center text-sm text-accent-content hover:text-blue-800 dark:hover:text-blue-300 mt-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Question
                    </button>
                </div>

                <x-button type="submit" class="bg-accent-content hover:bg-accent-content">
                    Save Quiz
                </x-button>
            </form>
        </div>

        <div x-show="$wire.activeTab === 'enrollments' && $wire.courseCreated" class="p-4 rounded-lg bg-white dark:bg-gray-800"
            x-transition>
            <h3 class="text-lg font-semibold mb-4 dark:text-white">Student Enrollments</h3>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="studentSearch">Search
                    Students</label>
                <div class="flex">
                    <x-input id="studentSearch" wire:model.live="studentSearch" class="w-full dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Search by name or email" />
                    <x-button type="button" class="ml-2 bg-accent-content hover:bg-accent-content">
                        Search
                    </x-button>
                </div>
            </div>

            <div class="mb-6">
                <h4 class="font-medium mb-2 dark:text-white">Available Students</h4>
                <div class="border rounded-md divide-y max-h-60 overflow-y-auto dark:border-gray-700 dark:divide-gray-700">
                    <!-- This would be replaced with search results -->
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium dark:text-gray-300">Search for students to enroll</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="font-medium mb-2 dark:text-white">Selected Students</h4>
                @if (count($selectedStudents) > 0)
                    <div class="border rounded-md divide-y dark:border-gray-700 dark:divide-gray-700">
                        @foreach ($selectedStudents as $index => $student)
                            <div class="p-3 flex items-center justify-between">
                                <div>
                                    <p class="font-medium dark:text-white">{{ $student['name'] }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $student['email'] }}</p>
                                </div>
                                <button type="button" wire:click="removeStudent({{ $index }})"
                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500 italic dark:text-gray-400">No students selected</div>
                @endif
            </div>

            <x-button type="button" wire:click="enrollStudents" class="bg-accent-content hover:bg-accent-content"
                :disabled="count($selectedStudents) === 0">
                Enroll Selected Students
            </x-button>
        </div>

        <div x-show="$wire.activeTab !== 'course' && !$wire.courseCreated" class="p-4 rounded-lg bg-white dark:bg-gray-800 text-center"
            x-transition>
            <div class="py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-white">Course details required</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Please complete and save the course details first before
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
</div>
</div>
