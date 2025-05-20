@props(['attributes' => new \Illuminate\View\ComponentAttributeBag])

<div
    x-data="setupEditor(@entangle($attributes->wire('model')))"
    x-init="init($refs.editor)"
    class="min-h-screen flex flex-col bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100"
    wire:ignore
>
    <!-- Top Navigation Bar -->
    <div class="sticky top-0 z-10 flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm">
        <h1 class="text-xl font-semibold">Create Course Material</h1>
        <div class="flex gap-2">
            <button @click="showPreview = false" :class="!showPreview ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white'"
                class="px-4 py-1.5 text-sm rounded-md hover:bg-blue-700">Edit</button>
            <button @click="showPreview = true" :class="showPreview ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white'"
                class="px-4 py-1.5 text-sm rounded-md hover:bg-blue-700">Preview</button>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-wrap items-center gap-2 p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
        <!-- Heading Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="px-3 py-1.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-sm rounded-md">Heading ▼</button>
            <div x-show="open" @click.outside="open = false" class="absolute z-20 mt-1 w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded shadow-md">
                <button @click="setHeading(1); open = false" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Heading 1</button>
                <button @click="setHeading(2); open = false" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Heading 2</button>
                <button @click="setHeading(3); open = false" class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100 dark:hover:bg-gray-700">Heading 3</button>
            </div>
        </div>

        <!-- Format Buttons -->
        <button @click="toggleBold()" class="toolbar-btn">Bold</button>
        <button @click="toggleItalic()" class="toolbar-btn">Italic</button>
        <button @click="toggleUnderline()" class="toolbar-btn">Underline</button>
        <button @click="toggleCode()" class="toolbar-btn">Code</button>

        <!-- Text Alignment -->
        <button @click="setAlign('left')" class="toolbar-btn">Left</button>
        <button @click="setAlign('center')" class="toolbar-btn">Center</button>
        <button @click="setAlign('right')" class="toolbar-btn">Right</button>
        <button @click="setAlign('justify')" class="toolbar-btn">Justify</button>

        <!-- Media -->
        <button @click="insertImage()" class="toolbar-btn bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-white">Image</button>
        <button @click="insertYoutube()" class="toolbar-btn bg-red-100 text-red-800 dark:bg-red-700 dark:text-white">YouTube</button>

        <!-- History -->
        <button @click="undo()" class="toolbar-btn">Undo</button>
        <button @click="redo()" class="toolbar-btn">Redo</button>
    </div>

    <!-- Main Editor / Preview Area -->
    <div class="flex-1 p-6">
        <div x-ref="editor" class="bg-white dark:bg-gray-800 border rounded p-4 min-h-[300px] overflow-auto prose dark:prose-invert"></div>

    </div>
    <style>
        .toolbar-btn {
            @apply px-3 py-1.5 text-sm rounded bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-800 dark:text-white;
        }
        </style>
</div>
