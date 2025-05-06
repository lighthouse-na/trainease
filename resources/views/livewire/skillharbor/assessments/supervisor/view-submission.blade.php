<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\SkillHarbor\SkillHarborEnrollment;
use App\Models\User;

new #[Layout('components.layouts.app.header')] class extends Component {
    //
    public $jcp;
    public $user;
    public $status;
    public $enrollment;
    public $skillRatings = [];

    public function mount(User $userId, $skillharborEnrollment)
    {
        $this->user = $userId->load('jcps.skills'); // Eager load relationships
        $this->jcp = $this->user->jcps;

        if ($this->jcp) {
            $this->skillRatings = $this->jcp->skills->pluck('pivot.user_rating', 'id')->toArray();
        }

        $this->enrollment = $this->user->getCurrentSkillHarborEnrollment($skillharborEnrollment);
        $this->status = $this->enrollment->supervisor_status; // Direct access instead of another query
    }

    public function submitAssessment()
    {
        $validated = $this->validate([
            'skillRatings.*' => 'required|integer|min:1|max:5',
        ]);

        // Batch update instead of individual updates
        $updates = collect($this->skillRatings)->map(fn($rating, $skillId) => [
            'skill_id' => $skillId,
            'supervisor_rating' => $rating,
            'updated_at' => now()
        ])->toArray();

        $this->jcp->skills()->sync($updates, false);

        if ($this->enrollment) {
            $this->enrollment->update([
                'supervisor_status' => 1,
                'user_status' => 1
            ]);
        }

        session()->flash('message', 'Assessment evaluated successfully.');
    }
}; ?>

<div class="min-h-screen bg-gray-50">
    @if ($jcp)
        <div class="container mx-auto px-4 py-8 max-w-7xl">
            <!-- Breadcrumb -->


            <!-- Main Two Column Grid -->
            <div class="grid lg:grid-cols-[2fr_1fr] gap-8">
                <!-- Left Column - Skills -->
                <div>
                    <!-- Skill Audit Table -->
                    <div class="bg-white rounded-lg border border-gray-200 ">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-accent to-accent-content rounded-t-lg text-white px-6 py-4">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="font-semibold">Competency</div>
                                <div class="text-center font-semibold col-span-2">Your Assessment</div>
                            </div>
                        </div>

                        <!-- Skills List -->
                        @forelse ($jcp->skills as $skill)
                            <div class="border-b border-gray-100 transition duration-150">
                                <div class="grid grid-cols-3 gap-4 px-6 py-4 items-center">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $skill->skill_title }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $skill->skill_description }}</p>
                                    </div>

                                    <div class=" col-span-2">
                                        <flux:radio.group wire:model="skillRatings.{{ $skill->id }}"
                                            variant="segmented" :disabled="$status === 1">
                                            <flux:radio value="1" label="Novice" class="text-red-600"
                                                data-checked-bg="bg-red-50" />
                                            <flux:radio value="2" label="Beginner" class="text-orange-600"
                                                data-checked-bg="bg-orange-50" />
                                            <flux:radio value="3" label="Competent" class="text-yellow-600"
                                                data-checked-bg="bg-yellow-50" />
                                            <flux:radio value="4" label="Proficient" class="text-lime-600"
                                                data-checked-bg="bg-lime-50" />
                                            <flux:radio value="5" label="Expert" class="text-green-600"
                                                data-checked-bg="bg-green-50" />
                                        </flux:radio.group>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <div class="container mx-auto px-4 py-8 max-w-xl ">
                                <flux:callout variant="warning" icon="exclamation-circle">
                                    <x-slot:heading>JCP Not Complete</x-slot:heading>
                                    <x-slot:text>
                                        Your JCP has not been assigned any Skills. Please consult your supervisor.
                                    </x-slot:text>
                                </flux:callout>
                            </div>
                        @endforelse

                        <!-- Submit Button -->
                        <div class="p-6 bg-gray-50 border-t border-gray-200">
                            <flux:button wire:click="submitAssessment" variant="primary"
                                :disabled="session('message') || $status === 1"
                                class="w-full justify-center disabled:bg-gray-400 text-white font-semibold py-3 rounded-b-lg transition">

                                @if (session('message'))
                                    Assessment Reviewed
                                @elseif($status === 1)
                                    Assessment Already Reviewed
                                @else
                                    Submit Assessment
                                @endif
                            </flux:button>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Compact Profile Info -->
                <div class="space-y-4">
                    <!-- Download Button -->
                    <flux:button as="a" href="#" variant="filled"
                        class="w-full justify-center text-sm font-semibold text-white bg-sky-600 hover:bg-sky-700 rounded-lg px-4 py-2.5 transition flex items-center space-x-2"
                        icon="arrow-down" icon:variant="outline">
                        Download Report
                    </flux:button>

                    <!-- Profile Card -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-accent to-accent-content  px-4 py-3">
                            <h2 class="text-lg font-semibold text-white">Profile Details</h2>
                        </div>

                        <div class="divide-y divide-gray-100">
                            <!-- Employee Info -->
                            <div class="flex items-center px-4 py-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-500">Employee</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                </div>
                            </div>

                            <!-- Position -->
                            <div class="flex items-center px-4 py-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-500">Position</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $jcp->position_title }}</p>
                                </div>
                            </div>

                            <!-- Grade -->
                            <div class="flex items-center px-4 py-3">
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-500">Grade</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $jcp->job_grade }}</p>
                                </div>
                            </div>

                            <!-- Purpose -->
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-500">Purpose</p>
                                <p class="text-sm text-gray-900 mt-1">{{ $jcp->job_purpose }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Qualifications Card -->
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-accent to-accent-content px-4 py-3">
                            <h2 class="text-lg font-semibold text-white">Required Qualifications</h2>
                        </div>

                        <div class="divide-y divide-gray-100">
                            @forelse ($jcp->qualifications as $qualification)
                                <div class="flex items-center justify-between px-4 py-3 hover:bg-gray-50">
                                    <span class="text-sm text-gray-900">{{ $qualification->qualification_title }}</span>
                                    @if ($qualification->user->contains(Auth::id()))
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Attained
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Missing
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <div class="px-4 py-3">
                                    <p class="text-sm text-gray-500">No qualifications assigned</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="container mx-auto px-4 py-8 max-w-xl ">
            <flux:callout variant="warning" icon="exclamation-circle">
                <x-slot:heading>JCP Not Complete</x-slot:heading>
                <x-slot:text>
                    Your JCP Is not complete. Please consult your supervisor.
                </x-slot:text>
            </flux:callout>
        </div>
    @endif
</div>
