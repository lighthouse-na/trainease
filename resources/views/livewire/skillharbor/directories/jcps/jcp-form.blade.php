<?php

use Livewire\Volt\Component;
use App\Models\SkillHarbor\Qualification;
use App\Models\SkillHarbor\Skill;
use App\Models\SkillHarbor\JobCompetencyProfile;
use App\Models\User;

new class extends Component {
    public $user;
    public $position_title ;
    public $job_grade;
    public $duty_station ;
    public $job_purpose ;

    public $selectedQualifications = [];
    public $selectedSkills = []; // Format: [skill_id => required_level]

    public function save()
    {
        $this->validate([
            'position_title' => 'required|string|max:255',
            'job_grade' => 'required|string|max:255',
            'duty_station' => 'required|string|max:255',
            'job_purpose' => 'required|string|max:1000',
            'selectedQualifications' => 'array',
            'selectedSkills' => 'array',
        ]);

        $jcp = JobCompetencyProfile::create([
            'user_id' => $this->user->id,
            'position_title' => $this->position_title,
            'job_grade' => $this->job_grade,
            'duty_station' => $this->duty_station,
            'job_purpose' => $this->job_purpose,
        ]);

        $jcp->qualifications()->attach($this->selectedQualifications);

        foreach ($this->selectedSkills as $skillId => $level) {
            $jcp->skills()->attach($skillId, ['required_level' => $level]);
        }

        session()->flash('success', 'JCP created successfully.');
        return redirect()->route('skill-harbor.directories.jcps');
    }

    public function with(): array
    {
        return [
            'qualifications' => Qualification::all(),
            'skills' => Skill::with('category')->get(),
        ];
    }

    public function mount($user){
        $this->user = User::find($user);
        $this->position_title = $this->user->jcps->position_title ?? '';
        $this->job_grade = $this->user->jcps->job_grade ?? '';
        $this->duty_station = $this->user->jcps->duty_station ?? '';
        $this->job_purpose = $this->user->jcps->job_purpose ?? '';
    }
};

?>

<div>
    <x-skillharbor.layout heading="{{ __('Create JCP') }}">
        <form wire:submit.prevent="save" class="max-w-4xl mx-auto space-y-6">
            <!-- Header Info -->
            <div class="bg-white p-4 border rounded-lg">
            <p class="text-sm text-gray-600">
            Creating JCP as: <span class="font-medium">{{ auth()->user()->name }}</span> for <span class="font-medium">{{ $user->name }}</span>
            </p>
            </div>

            <!-- Basic Information Section -->
            <div class="bg-white p-6 border rounded-lg space-y-6">
            <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
            <div class="grid grid-cols-2 gap-4">
            <flux:input
                wire:model="position_title"
                label="Position Title"
                placeholder="e.g., Senior Software Engineer"
                required
            />
            <flux:select wire:model="job_grade" label="Job Grade" required>
            <option value="">Select a job grade</option>
            <option value="G1">Grade 1</option>
            <option value="G2">Grade 2</option>
            <option value="G3">Grade 3</option>
            <option value="G4">Grade 4</option>
            <option value="G5">Grade 5</option>
            </flux:select>
            </div>
            <flux:input
            wire:model="duty_station"
            label="Duty Station"
            placeholder="e.g., New York Office"
            required
            />
            <flux:textarea
            wire:model="job_purpose"
            label="Job Purpose"
            placeholder="Describe the main purpose and objectives of this position..."
            required
            rows="4"
            />
            </div>

            <!-- Qualifications Section -->
            <div class=" p-6 border rounded-lg">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Qualifications</h2>
            <div
            x-data="{
                selected: [],
                options: {{ $qualifications->map(fn($q) => ['id' => $q->id, 'title' => $q->qualification_title])->toJson() }},
                toggle(id) {
                    this.selected.includes(id)
                        ? this.selected = this.selected.filter(i => i !== id)
                        : this.selected.push(id);
                },
                isSelected(id) {
                    return this.selected.includes(id);
                }
            }"
            class="space-y-2"
        >
            <!-- Chips -->
            <div class="flex flex-wrap gap-2">
                <template x-for="id in selected" :key="id">
                    <span class="bg-accent text-white text-sm px-3 py-1 rounded-full flex items-center">
                        <span x-text="options.find(o => o.id === id)?.title"></span>
                        <button type="button" class="ml-2 text-xs" @click="toggle(id)">✕</button>
                    </span>
                </template>
            </div>

            <!-- Options -->
            <div class="flex flex-wrap gap-2">
                <template x-for="option in options" :key="option.id">
                    <button type="button"
                        class="px-3 py-1 text-sm rounded border"
                        :class="isSelected(option.id)
                            ? 'bg-accent text-white border-accent'
                            : 'bg-white text-gray-700 border-gray-300'"
                        @click="toggle(option.id)"
                    >
                        <span x-text="option.title"></span>
                    </button>
                </template>
            </div>

            <!-- Hidden Inputs -->
            <template x-for="id in selected" :key="id">
                <input type="hidden" name="selectedQualifications[]" :value="id">
            </template>
        </div>

            </div>
            <!-- Skills Section -->
            <div x-data="{
                activeTab: '{{ $skills->first()?->category?->category_title ?? 'General' }}',
                selectedSkills: @entangle('selectedSkills').defer
            }" class="bg-white p-6 border rounded-lg space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Required Skills</h2>

                <!-- Tabs -->
                <div class="flex flex-wrap gap-2 border-b border-gray-200">
                    @foreach ($skills->groupBy('category.category_title') as $category => $skillGroup)
                        <button type="button"
                            class="px-4 py-2 text-sm font-medium rounded-t-lg transition-colors duration-200"
                            :class="activeTab === '{{ $category }}'
                                ? 'bg-accent text-white border-b-2 border-accent'
                                : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50'"
                            @click="activeTab = '{{ $category }}'">
                            {{ $category }}
                        </button>
                    @endforeach
                </div>

                <!-- Tab Content -->
                @foreach ($skills->groupBy('category.category_title') as $category => $skillGroup)
                    <div x-show="activeTab === '{{ $category }}'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        class="space-y-3">

                        <!-- Selected Skills Summary -->
                        <div class="flex flex-wrap gap-2 min-h-[2rem]">
                            <template x-for="(level, id) in selectedSkills" :key="id">
                                <div class="inline-flex items-center bg-accent text-white rounded-full px-3 py-1 text-sm">
                                    <span x-text="'Level ' + level + ' - ' + {{ $skills->toJson() }}.find(s => s.id == id)?.skill_title"></span>
                                    <button type="button" class="ml-2 text-white hover:text-accent"
                                        @click="delete selectedSkills[id]">×</button>
                                </div>
                            </template>
                        </div>

                        <!-- Skills Grid -->
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach ($skillGroup as $skill)
                                <div class="p-4 border rounded-lg hover:shadow-sm transition-shadow bg-gray-50">
                                    <div class="flex items-center justify-between gap-4">
                                        <label class="text-sm font-medium w-full text-gray-700">{{ $skill->skill_title }}</label>
                                        <flux:select
                                            wire:model.defer="selectedSkills.{{ $skill->id }}"
                                        >
                                            <flux:select.option value="">Level</flux:select.option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <flux:select.option value="{{ $i }}">Level {{ $i }}</flux:select.option>
                                            @endfor
                                        </flux:select>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">{{ Str::limit($skill->description ?? 'No description available.', 100) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Submit Button -->

            </div>
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="w-full sm:w-auto px-4 py-2 bg-accent text-white rounded-md hover:bg-accent
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent transition-colors">
                    Save Job Competency Profile
                </button>
            </div>
    </x-skillharbor.layout>
</div>
