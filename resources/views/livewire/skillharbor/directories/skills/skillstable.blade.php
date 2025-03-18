<?php

use Livewire\Volt\Component;
use App\Models\SkillHarbor\Skill;
use App\Models\SkillHarbor\SkillCategory;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $query = '';
    public $search = '';
    public $skill = '';
    public $skillId = '';
    public $skillDescription = '';
    public $categoryId = '';
    public $selectedCategory = '';

    public $skillCategory = '';

    public function search()
    {
        $this->resetPage();
    }

    public function with(): array
    {
        $query = Skill::with('category')->where(function ($q) {
            $q->where('skill_title', 'like', '%' . $this->search . '%')->orWhere('skill_description', 'like', '%' . $this->search . '%');
        });

        if ($this->selectedCategory) {
            $query->where('skill_category_id', $this->selectedCategory);
        }

        return [
            'skills' => $query->cursorPaginate(10),
            'categories' => SkillCategory::all(),
        ];
    }

    public function addNewCategory()
    {
        $this->validate([
            'skillCategory' => 'required|string|max:255',
        ]);

        SkillCategory::create([
            'category_title' => $this->skillCategory,
        ]);

        $this->resetFields();
        $this->modal('skillCategoryModal')->close();
    }

    public function editCategory($categoryId)
    {
        $category = SkillCategory::find($categoryId);
        $this->skillCategory = $category->category_title;
        $this->categoryId = $category->id;
        $this->modal('skillCategoryModal')->show();
    }

    public function updateCategory()
    {
        $this->validate([
            'skillCategory' => 'required|string|max:255',
        ]);

        $category = SkillCategory::find($this->categoryId);
        $category->update([
            'category_title' => $this->skillCategory,
        ]);

        $this->resetFields();
        $this->modal('skillCategoryModal')->close();
    }

    public function deleteCategory($catergoryId)
    {
        // Check if the category has skills
        $category = SkillCategory::with('skills')->find($catergoryId);

        // Delete all skills associated with this category
        if ($category && $category->skills->count() > 0) {
            foreach ($category->skills as $skill) {
                $skill->delete();
            }
        }
        SkillCategory::find($catergoryId)->delete();
    }

    public function addNewSkill()
    {
        $this->validate([
            'skill' => 'required|string|max:255',
            'skillDescription' => 'required|string',
            'categoryId' => 'required|exists:skill_categories,id',
        ]);

        Skill::create([
            'skill_title' => $this->skill,
            'skill_description' => $this->skillDescription,
            'skill_category_id' => $this->categoryId,
        ]);

        $this->resetFields();
        $this->modal('skillModal')->close();
    }

    public function deleteSkill($skill_id)
    {
        Skill::find($skill_id)->delete();
    }

    public function editSkill($skill_id)
    {
        $skill = Skill::find($skill_id);
        $this->skill = $skill->skill_title;
        $this->skillDescription = $skill->skill_description;
        $this->categoryId = $skill->skill_category_id;
        $this->skillId = $skill->id;
        $this->modal('skillModal')->show();
    }

    public function updateSkill()
    {
        $this->validate([
            'skill' => 'required|string|max:255',
            'skillDescription' => 'required|string',
            'categoryId' => 'required|exists:skill_categories,id',
        ]);

        $skill = Skill::find($this->skillId);
        $skill->update([
            'skill_title' => $this->skill,
            'skill_description' => $this->skillDescription,
            'skill_category_id' => $this->categoryId,
        ]);

        $this->resetFields();
        $this->modal('skillModal')->close();
    }

    public function filterByCategory($categoryId = null)
    {
        $this->selectedCategory = $categoryId;
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->skill = '';
        $this->skillDescription = '';
        $this->categoryId = '';
        $this->skillId = '';
    }

    public function mount() {}
}; ?>

<div>
    <x-skillharbor.layout heading="{{ __('Skills') }}" subheading="{{ __('View and manage the system skills') }}">
        <div class="mb-6">
            <!-- Top controls: Create buttons -->
            <div class="flex justify-between items-center mb-4 border rounded-lg p-2 bg-gray-100">

                <h3 class="text-lg font-medium text-gray-700">Manage Skills</h3>
                <div class="flex space-x-2">
                    <flux:modal.trigger name="skillModal">
                        <flux:button icon="plus" variant="primary" class="m-3">{{ __('Create Skill') }}</flux:button>
                    </flux:modal.trigger>
                    <flux:modal.trigger name="skillCategoryModal">
                        <flux:button icon="plus" color="zinc" class="m-3">{{ __('Create Category') }}</flux:button>
                    </flux:modal.trigger>
                </div>
            </div>

            <!-- Search and filter section -->
            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:items-center md:space-x-4">
                <!-- Search input -->
                <div class="w-full md:w-1/3">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        icon="magnifying-glass"
                        placeholder="Search skills"
                        class="w-full"
                    />
                </div>

                <!-- Categories filter -->
                <div class="flex-1 overflow-x-auto pb-1">
                    <div class="flex space-x-2">
                        <flux:button
                            size="sm"
                            color="{{ !$selectedCategory ? 'primary' : 'zinc' }}"
                            wire:click="filterByCategory()">
                            All
                        </flux:button>

                        @foreach ($categories as $category)
                            <div x-data="{
                                contextMenuOpen: false,
                                categoryId: {{ $category->id }},
                                contextMenuToggle: function(event) {
                                    this.contextMenuOpen = true;
                                    event.preventDefault();
                                    this.$refs.contextmenu.classList.add('opacity-0');
                                    let that = this;
                                    $nextTick(function() {
                                        that.calculateContextMenuPosition(event);
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
                                }
                            }"
                            x-init="window.addEventListener('resize', function(event) { contextMenuOpen = false; });"
                            @contextmenu="contextMenuToggle($event)"
                            class="relative">
                                <flux:button
                                    size="sm"
                                    color="{{ $selectedCategory == $category->id ? 'primary' : 'zinc' }}"
                                    wire:click="filterByCategory({{ $category->id }})">
                                    {{ $category->category_title }}
                                </flux:button>

                                <template x-teleport="body">
                                    <div
                                        x-show="contextMenuOpen"
                                        @click.away="contextMenuOpen=false"
                                        x-ref="contextmenu"
                                        class="z-50 min-w-[8rem] rounded-md border border-neutral-200/70 bg-white text-sm fixed p-1 shadow-md w-48"
                                        x-cloak>
                                        <div
                                            @click="$wire.editCategory(categoryId); contextMenuOpen=false"
                                            class="relative flex cursor-pointer select-none items-center rounded px-2 py-1.5 hover:bg-neutral-100">
                                            <span class="mr-2">
                                                <flux:icon name="pencil" class="w-4 h-4" />
                                            </span>
                                            <span>Edit Category</span>
                                        </div>
                                        <div
                                            @click="$wire.deleteCategory(categoryId); contextMenuOpen=false"
                                            class="relative flex cursor-pointer select-none items-center rounded px-2 py-1.5 hover:bg-red-100 hover:text-red-600">
                                            <flux:icon name="trash" class="w-4 h-4" />
                                            <span class="ml-2">Delete Category</span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($skills as $skill)
                <div class="flex flex-col items-start justify-between gap-y-3 border rounded-lg p-4" data-slot="field">
                    <div class="w-full">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-strong">{{ $skill->skill_title }}</h4>
                            <div class="flex justify-end items-center gap-2">
                                <flux:button color="zinc" icon="pencil" size="xs"
                                    wire:click="editSkill({{ $skill->id }})"></flux:button>
                                <flux:button variant="danger" icon="trash"
                                    wire:click="deleteSkill({{ $skill->id }})" size="xs"></flux:button>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">{{ $skill->skill_description }}</p>
                        <div class="mt-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $skill->category->category_title ?? 'Uncategorized' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $skills->links() }}
        </div>
    </x-skillharbor.layout>

    <flux:modal name="skillModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $skillId ? 'Edit Skill' : 'Create New Skill' }}</flux:heading>
                <flux:subheading>Enter the skill details below.</flux:subheading>
            </div>

            <flux:input wire:model="skill" placeholder="Enter skill title" label="Skill title" />

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Skill description</label>
                <textarea wire:model="skillDescription" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="Enter skill description"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select wire:model="categoryId"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="{{ $skillId ? 'updateSkill' : 'addNewSkill' }}" variant="primary">
                    {{ $skillId ? 'Update Skill' : 'Create Skill' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
    <flux:modal name="skillCategoryModal" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $skillCategory ? 'Edit Category' : 'Create New Category' }}
                </flux:heading>
                <flux:subheading>Enter the skill details below.</flux:subheading>
            </div>

            <flux:input wire:model="skillCategory" placeholder="Enter category title" label="Category title" />

            <div class="flex">
                <flux:spacer />
                <flux:button wire:click="{{ $skillCategory ? 'updateCategory' : 'addNewCategory' }}" variant="primary">
                    {{ $skillCategory ? 'Update Category' : 'Create Category' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
