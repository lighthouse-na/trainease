@props(['attributes' => new \Illuminate\View\ComponentAttributeBag])
<div
    x-data="setupEditor(@entangle($attributes->wire('model')))"
    x-init="init($refs.editor)"
    wire:ignore
    class="border rounded-lg p-4 bg-white "
>
    <!-- Toolbar -->
    <div class="mb-2 flex space-x-2">
        <button @click="toggleBold()" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-sm font-semibold rounded-md">
            Bold
        </button>
        <button @click="toggleItalic()" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-sm font-semibold rounded-md">
            Italic
        </button>
        <button @click="toggleUnderline()" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-sm font-semibold rounded-md">
            Underline
        </button>
        <button @click="toggleCode()" class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-sm font-semibold rounded-md">
            Code
        </button>
        <button @click="insertImage()" class="px-3 py-1 bg-blue-200 hover:bg-blue-300 text-sm font-semibold rounded-md">
            Insert Image
        </button>
        <button @click="insertYoutube()" class="px-3 py-1 bg-red-200 hover:bg-red-300 text-sm font-semibold rounded-md">
            Insert YouTube
        </button>
    </div>

    <!-- Editor Content -->
    <div x-ref="editor" class="min-h-[150px]  rounded-md p-3 "></div>
</div>

