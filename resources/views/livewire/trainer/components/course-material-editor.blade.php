<?php

use Livewire\Volt\Component;
use App\Models\Training\CourseMaterial;
use App\Models\Training\Course;


new class extends Component {
    //

    public $course;
    public $courseMaterials= [];
    public string $materialTitle= '';
    public string $materialDescription= '';
    public string $materialContent= '';
    public int $editingMaterialId;
    public bool $isEditingMaterial= false;

    public function mount($course){
        $this->courseMaterials= Course::find($course)->materials ?? [];
        $this->courseCreated= true;
    }

    //imported course properties
    public int $importedCourseId;
    public $importedMaterials= [];

    public function saveMaterial()
    {
        if (!$this->courseCreated) {
            return;
        }

        // Validate material data
        $this->validate([
            'materialTitle'=> 'required|min:3',
            'materialDescription'=> 'required',
            'materialContent'=> 'required',
        ]);

        // Get the course
        $course= Course::find($this->courseId);

        // Create the material
        $course->materials()->create([
            'material_name'=> $this->materialTitle,
            'description'=> $this->materialDescription,
            'material_content'=> $this->materialContent,
        ]);

        // Reset the form fields
        $this->materialTitle= '';
        $this->materialDescription= '';
        $this->materialContent= '';
        $this->materialFile= null;

        // Refresh the materials list
        $this->courseMaterials= $course->materials;
        $this->modal('materialModal')->close();
    }

    public function editMaterial($materialId)
    {
        if (!$this->courseCreated) {
            return;
        }
        $this->isEditingMaterial= true;
        $this->modal('materialModal')->show();
        // Find the material from the course materials collection
        $material= $this->courseMaterials->find($materialId);

        if ($material) {
            // Populate the form fields with the material data
            $this->materialTitle= $material->material_name;
            $this->materialDescription= $material->description;
            $this->materialContent= $material->material_content;

            // Set active tab to materials to display the edit form
            $this->activeTab= 'materials';

            // Store the material ID for update
            $this->editingMaterialId= $materialId;
        }
    }

    public function deleteMaterial($materialId)
    {
        if (!$this->courseCreated) {
            return;
        }

        // Find the course
        $course= Course::find($this->courseId);

        // Find the material and delete it
        $material= $course->materials()->find($materialId);

        if ($material) {
            $material->delete();

            // Refresh the materials list
            $this->courseMaterials= $course->materials;

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
            'materialTitle'=> 'required|min:3',
            'materialDescription'=> 'required',
            'materialContent'=> 'required',
        ]);

        // Get the course
        $course= Course::find($this->courseId);

        // Find the material and update it
        $material= $course->materials()->find($this->editingMaterialId);

        if ($material) {
            $material->update([
                'material_name'=> $this->materialTitle,
                'description'=> $this->materialDescription,
                'material_content'=> $this->materialContent,
            ]);

            // Reset form fields
            $this->materialTitle= '';
            $this->materialDescription= '';
            $this->materialContent= '';
            $this->materialFile= null;
            $this->editingMaterialId;
            $this->isEditingMaterial= false;

            // Refresh the materials list
            $this->modal('materialModal')->close();
            $this->courseMaterials= $course->materials;

            session()->flash('message', 'Course material updated successfully!');
        }
    }

    /**
     * Import course materials from the selected course to the current course
     *
     * @return void
     */
    public function importMaterial(): void
    {
        // Validate that a course is selected
        if (empty($this->importedCourseId)) {
            $this->addError('importedCourseId', 'Please select a course to import materials from.');
            return;
        }

        // Get the current course ID
        $currentCourseId= $this->courseId;

        // Get materials from the selected course
        $materialsToImport= CourseMaterial::where('course_id', $this->importedCourseId)->get();

        // Count for success message
        $importCount= 0;

        // Begin transaction to ensure data integrity
        DB::beginTransaction();

        try {
            // First, delete all existing materials for the current course
            CourseMaterial::where('course_id', $currentCourseId)->delete();

            // Then import new materials
            foreach ($materialsToImport as $material) {
                // Create a new material record for the current course
                $newMaterial= new CourseMaterial();
                $newMaterial->course_id= $currentCourseId;
                $newMaterial->material_name= $material->material_name;
                $newMaterial->description= $material->description;
                $newMaterial->material_content= $material->material_content;

                // Save the new material
                $newMaterial->save();

                $importCount++;
            }

            // Commit the transaction if all goes well
            DB::commit();

            // Success notification

            session()->flash('message', "Existing materials removed and {$importCount} new materials imported successfully!"
            );

            // Close the modal
            $this->isModalOpen= false;

            // Refresh the materials list for the current course
            $this->refreshCourseMaterials();

        } catch (Exception $e) {
            // Rollback in case of error
            DB::rollBack();

            // Log the error for debugging
            Log::error('Course material import failed: ' . $e->getMessage(), [
                'exception'=> $e,
                'from_course_id'=> $this->importedCourseId,
                'to_course_id'=> $currentCourseId
            ]);

            // Error notification
            $this->dispatch('notify', [
                'type'=> 'error',
                'message'=> "Failed to import materials: " . $e->getMessage()
            ]);
        }
        $this->modal('importModal')->close();
    }

    /**
     * This method is triggered when a course is selected in the dropdown
     * It loads the materials for preview before import
     *
     * @param mixed $value The selected course ID
     * @return void
     */
    public function updatedImportedCourseId(mixed $value): void
    {
        if (!empty($value)) {
            // Load materials for the selected course
            $this->importedMaterials= CourseMaterial::where('course_id', $value)->get();
        } else {
            $this->importedMaterials= [];
        }
    }

    /**
     * Refresh the course materials after import
     *
     * @return void
     */
    protected function refreshCourseMaterials(): void
    {
        // Update the materials property with fresh data
        $this->materials= CourseMaterial::where('course_id', $this->courseId)->get();
    }

}; ?>

<div>
    <div class="flex min-h-screen bg-slate-100 dark:bg-slate-900">
        <!-- Sidebar with materials and Add button -->
        <aside class="w-80 border-r dark:border-gray-700 p-6 overflow-y-auto bg-white dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Course Materials</h2>
                @foreach ($courseMaterials as $material)
                <div class="cursor-pointer border rounded-md p-3 mb-2 hover:bg-blue-50 dark:hover:bg-gray-700"
                :class="activeMaterialId === {{$material->id}} ? 'bg-blue-100 dark:bg-blue-800 text-blue-900 dark:text-white font-semibold' : 'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200'"
                @click="loadMaterial({{ $material->id }})">

               <span x-text="{{ $material->material_name }}">{{ $material->material_name }}</span>
           </div>
                @endforeach


            <button @click="addNewMaterial" class="mt-6 w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                Add Material
            </button>
        </aside>

        <!-- Editor Content -->
        <div x-data="setupEditor()"
             x-init="init($refs.editor)"
             class="flex-1 flex flex-col w-full"
             wire:ignore>

            <!-- Top Navigation Bar -->
            <div class="w-fullsticky top-0 z-10 flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm max-w-full">
                <input type="text" x-model="materialTitle" placeholder="Material Title"
                       class="w-full text-xl font-semibold bg-transparent focus:outline-none text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
                <div class="ml-4 flex gap-2">
                    <button @click="showPreview = false" :class="!showPreview ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white'"
                        class="px-4 py-1.5 text-sm rounded-md hover:bg-blue-700">Edit</button>
                    <button @click="showPreview = true" :class="showPreview ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white'"
                        class="px-4 py-1.5 text-sm rounded-md hover:bg-blue-700">Preview</button>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="flex flex-wrap items-center gap-2 p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 w-full" >
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="px-3 py-1.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm rounded-md">Heading ▼</button>
                    <div x-show="open" @click.outside="open = false" class="absolute z-20 mt-1 w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded shadow-md">
                        <button @click="setHeading(1); open = false" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Heading 1</button>
                        <button @click="setHeading(2); open = false" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Heading 2</button>
                        <button @click="setHeading(3); open = false" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Heading 3</button>
                    </div>
                </div>

                <button @click="toggleBold()" class="toolbar-btn">Bold</button>
                <button @click="toggleItalic()" class="toolbar-btn">Italic</button>
                <button @click="toggleUnderline()" class="toolbar-btn">Underline</button>
                <button @click="toggleCode()" class="toolbar-btn">Code</button>

                <button @click="setAlign('left')" class="toolbar-btn">Left</button>
                <button @click="setAlign('center')" class="toolbar-btn">Center</button>
                <button @click="setAlign('right')" class="toolbar-btn">Right</button>
                <button @click="setAlign('justify')" class="toolbar-btn">Justify</button>

                <button @click="$refs.fileInput.click()" class="toolbar-btn bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white">Upload Image</button>
                <input type="file" x-ref="fileInput" @change="uploadImage($event)" class="hidden" accept="image/*">

                <button @click="undo()" class="toolbar-btn">Undo</button>
                <button @click="redo()" class="toolbar-btn">Redo</button>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 p-6 relative overflow-auto" @drop.prevent="dropImage($event)" @dragover.prevent>
                <template x-if="!showPreview">
                    <div x-ref="editor"
                        class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg p-6 min-h-[500px] overflow-auto focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-md prose dark:prose-invert max-w-full">
                    </div>
                </template>

                <template x-if="showPreview">
                    <div x-html="editor.getHTML()"
                        class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-lg p-6 min-h-[500px] overflow-auto prose dark:prose-invert max-w-full">
                    </div>
                </template>

                <div x-show="unsavedChanges" class="fixed bottom-6 right-6">
                    <button @click="saveMaterial" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-md">
                        <span x-text="isSaving ? 'Saving...' : 'Save Material'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
