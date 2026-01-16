<?php

use Livewire\Volt\Component;
use App\Models\Training\CourseMaterial;
use App\Models\Training\Course;

new class extends Component {
    public $course;
    public $courseMaterials = [];
    public string $materialTitle = '';
    public string $materialDescription = '';
    public array $contentBlocks = [];
    public ?int $editingMaterialId = null;

    public function mount($course)
    {
        $this->course = Course::find($course);
        if ($this->course) {
            $this->courseMaterials = $this->course->materials ?? [];
            if ($firstMaterial = $this->courseMaterials->first()) {
                $this->loadMaterial($firstMaterial->id);
            }
        }
    }

    public function addBlock($type)
    {
        if ($type === 'video') {
            $this->contentBlocks[] = ['type' => 'video', 'youtube_url' => ''];
        } else {
            $this->contentBlocks[] = ['type' => $type, 'content' => ''];
        }
    }

    public function addVideoBlock($youtubeLink)
    {
        $normalizedUrl = $this->normalizeYoutubeUrl($youtubeLink);
        $this->contentBlocks[] = ['type' => 'video', 'youtube_url' => $normalizedUrl];
    }

    public function addListItem()
    {
        if (empty($this->contentBlocks) || $this->contentBlocks[array_key_last($this->contentBlocks)]['type'] !== 'list') {
            $this->contentBlocks[] = ['type' => 'list', 'items' => []];
        }
        $this->contentBlocks[array_key_last($this->contentBlocks)]['items'][] = ['type' => 'list-item', 'content' => ''];
    }

    public function removeContentBlock($blockIndex, $itemIndex = null)
    {
        if ($itemIndex !== null) {
            unset($this->contentBlocks[$blockIndex]['items'][$itemIndex]);
            $this->contentBlocks[$blockIndex]['items'] = array_values($this->contentBlocks[$blockIndex]['items']);
            if (empty($this->contentBlocks[$blockIndex]['items'])) {
                unset($this->contentBlocks[$blockIndex]);
            }
        } else {
            unset($this->contentBlocks[$blockIndex]);
        }
        $this->contentBlocks = array_values($this->contentBlocks);
    }

    public function loadMaterial($materialId)
    {
        $material = CourseMaterial::find($materialId);
        if ($material) {
            $this->materialTitle = $material->material_name;
            $this->materialDescription = $material->description;
            $this->editingMaterialId = $material->id;

            // Convert Markdown to content blocks
            $this->contentBlocks = $this->parseMarkdown($material->material_content);
        }
    }

    public function updateMaterial()
    {
        if (!$this->editingMaterialId) {
            return;
        }

        $material = CourseMaterial::find($this->editingMaterialId);
        if ($material) {
            $markdownContent = $this->generateMarkdown();
            $material->update([
                'material_name' => $this->materialTitle,
                'description' => $this->materialDescription,
                'material_content' => $markdownContent,
            ]);

            session()->flash('message', 'Course material updated successfully!');
        }
    }

    private function parseMarkdown($markdown)
    {
        $blocks = [];
        $lines = explode("\n", $markdown);

        // If the markdown is empty or only contains a single empty line, return empty blocks
        if (count($lines) === 1 && $lines[0] === '') {
            return [];
        }

        $inList = false;

        foreach ($lines as $line) {
            if (str_starts_with($line, '# ')) {
                $blocks[] = ['type' => 'heading1', 'content' => substr($line, 2)];
                $inList = false;
            } elseif (str_starts_with($line, '## ')) {
                $blocks[] = ['type' => 'heading2', 'content' => substr($line, 3)];
                $inList = false;
            } elseif (str_starts_with($line, '### ')) {
                $blocks[] = ['type' => 'heading3', 'content' => substr($line, 4)];
                $inList = false;
            } elseif (str_starts_with($line, '- ') || str_starts_with($line, '* ')) {
                if (!$inList) {
                    $blocks[] = ['type' => 'list', 'items' => []];
                    $inList = true;
                }
                $blocks[array_key_last($blocks)]['items'][] = ['type' => 'list-item', 'content' => substr($line, 2)];
            } elseif (preg_match('/<iframe.*src="(https:\/\/www\.youtube\.com\/embed\/[^"]+)".*><\/iframe>/', $line, $matches)) {
                $blocks[] = ['type' => 'video', 'youtube_url' => $matches[1]];
                $inList = false;
            } else {
                $blocks[] = ['type' => 'text', 'content' => $line];
                $inList = false;
            }
        }

        return $blocks;
    }

    private function generateMarkdown()
    {
        $markdown = [];
        foreach ($this->contentBlocks as $block) {
            switch ($block['type']) {
                case 'heading1':
                    $markdown[] = '# ' . $block['content'];
                    break;
                case 'heading2':
                    $markdown[] = '## ' . $block['content'];
                    break;
                case 'heading3':
                    $markdown[] = '### ' . $block['content'];
                    break;
                case 'list':
                    foreach ($block['items'] as $item) {
                        $markdown[] = '- ' . $item['content'];
                    }
                    break;
                case 'text':
                    $markdown[] = $block['content'];
                    break;
                case 'video':
                    $markdown[] = '<iframe width="560" height="315" src="' . $block['youtube_url'] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                    break;
            }
        }

        return implode("\n", $markdown);
    }

    public function updatedContentBlocks($value, $key)
    {
        // Check if the updated block is a video block and its youtube_url is being updated
        if (preg_match('/^contentBlocks\.(\d+)\.youtube_url$/', $key, $matches)) {
            $index = $matches[1];
            $this->contentBlocks[$index]['youtube_url'] = $this->normalizeYoutubeUrl($value);
        }
    }

    private function normalizeYoutubeUrl($url)
    {
        // Extract video ID from various YouTube URL formats
        $videoId = null;
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $matches)) {
            $videoId = $matches[1];
        }

        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId;
        }

        return $url; // Return original URL if unable to normalize
    }
};

?>

<div class=" w-full h-full">
    <div class="flex min-h-screen bg-slate-100 dark:bg-slate-900">
        <!-- Sidebar with materials and Add button -->
        <aside class="w-70 border-r dark:border-gray-700 p-6 overflow-y-auto bg-white dark:bg-gray-800">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Course Materialhhhs</h2>
            @foreach ($courseMaterials as $material)
                <div class="cursor-pointer border rounded-md p-3 mb-2 hover:bg-blue-50 dark:hover:bg-gray-700"
                    :class="{{ $editingMaterialId }} === {{ $material->id }} ?
                        'bg-blue-100 dark:bg-blue-800 text-blue-900 dark:text-white font-semibold' :
                        'bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200'"
                    wire:click="loadMaterial({{ $material->id }})">
                    <span>{{ $material->material_name }}</span>
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
        <div class="flex-1 flex flex-col ">
            <!-- Title Textarea -->
            <div
                class="w-fullsticky top-0 z-10 flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm max-w-full">
                <input type="text" wire:model.lazy="materialTitle" placeholder="Material Title"
                    class="w-full text-xl font-semibold bg-transparent focus:outline-none text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" />
            </div>

            <!-- Description Textarea -->
            <div class="px-6 py-2 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <textarea wire:model.lazy="materialDescription" placeholder="Material Description"
                    class="w-full text-sm bg-transparent focus:outline-none text-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500"
                    x-data="{ resize: () => { $el.style.height = 'auto';
                            $el.style.height = $el.scrollHeight + 'px' } }" x-init="resize()" @input="resize()"></textarea>
            </div>

            <!-- Content Blocks -->
            <div class="px-6 py-2 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                @foreach ($contentBlocks as $index => $block)
                    @if ($block['type'] === 'heading1')
                        <div class="flex items-center mb-2">
                            <input type="text" wire:model="contentBlocks.{{ $index }}.content"
                                class="w-full text-2xl font-bold bg-transparent focus:outline-none text-gray-900 dark:text-white"
                                placeholder="Heading 1" x-data="{ resize: () => { $el.style.height = 'auto';
                                        $el.style.height = $el.scrollHeight + 'px' } }" x-init="resize()"
                                @input="resize()" />
                            <button wire:click="removeContentBlock({{ $index }})" class="ml-2 text-red-500">
                                Remove
                            </button>
                        </div>
                    @elseif ($block['type'] === 'heading2')
                        <div class="flex items-center mb-2">
                            <input type="text" wire:model="contentBlocks.{{ $index }}.content"
                                class="w-full text-xl font-bold bg-transparent focus:outline-none text-gray-900 dark:text-white"
                                placeholder="Heading 2" x-data="{ resize: () => { $el.style.height = 'auto';
                                        $el.style.height = $el.scrollHeight + 'px' } }" x-init="resize()"
                                @input="resize()" />
                            <button wire:click="removeContentBlock({{ $index }})" class="ml-2 text-red-500">
                                Remove
                            </button>
                        </div>
                    @elseif ($block['type'] === 'heading3')
                        <div class="flex items-center mb-2">
                            <input type="text" wire:model="contentBlocks.{{ $index }}.content"
                                class="w-full text-lg font-bold bg-transparent focus:outline-none text-gray-900 dark:text-white"
                                placeholder="Heading 3" x-data="{ resize: () => { $el.style.height = 'auto';
                                        $el.style.height = $el.scrollHeight + 'px' } }" x-init="resize()"
                                @input="resize()" />
                            <button wire:click="removeContentBlock({{ $index }})" class="ml-2 text-red-500">
                                Remove
                            </button>
                        </div>
                    @elseif ($block['type'] === 'list')
                        <ul class="list-disc list-inside mb-2 pl-4">
                            @foreach ($block['items'] as $itemIndex => $item)
                                <li class="flex items-center mb-1">
                                    <input type="text"
                                        wire:model="contentBlocks.{{ $index }}.items.{{ $itemIndex }}.content"
                                        class="w-full text-sm bg-transparent focus:outline-none text-gray-700 dark:text-gray-200"
                                        placeholder="List item" x-data="{ resize: () => { $el.style.height = 'auto';
                                                $el.style.height = $el.scrollHeight + 'px' } }" x-init="resize()"
                                        @input="resize()" />
                                    <button wire:click="removeContentBlock({{ $index }}, {{ $itemIndex }})"
                                        class="ml-2 text-red-500">
                                        Remove
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @elseif ($block['type'] === 'video')
                        <div class="flex flex-col mb-2">
                            <div
                                class="aspect-w-16 aspect-h-9 w-full mb-2 bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                @if ($block['youtube_url'])
                                    <iframe width="560" height="315" src="{{ $block['youtube_url'] }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                @else
                                    <p>Paste YouTube link in the input below to see video preview.</p>
                                @endif
                            </div>
                            <div class="flex items-center">
                                <input type="text" wire:model="contentBlocks.{{ $index }}.youtube_url"
                                    class="w-full text-sm bg-transparent focus:outline-none text-gray-700 dark:text-gray-200"
                                    placeholder="YouTube Embed URL" />
                                <button wire:click="removeContentBlock({{ $index }})" class="ml-2 text-red-500">
                                    Remove
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center mb-2">
                            <textarea wire:model="contentBlocks.{{ $index }}.content"
                                class="w-full text-sm bg-transparent focus:outline-none text-gray-700 dark:text-gray-200"
                                placeholder="Start writing..." x-data="{ resize: () => { $el.style.height = 'auto';
                                        $el.style.height = $el.scrollHeight + 'px' } }" x-init="resize()" @input="resize()"></textarea>
                            <button wire:click="removeContentBlock({{ $index }})" class="ml-2 text-red-500">
                                Remove
                            </button>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Toolbar -->
            <div class="sticky bottom-0 z-10 p-4 bg-white dark:bg-gray-900 shadow-lg flex flex-wrap items-center justify-between gap-3 border-t border-gray-200 dark:border-gray-700">
                <button wire:click="addBlock('heading1')" class="px-4 py-2 bg-blue-500 text-white rounded">H1</button>
                <button wire:click="addBlock('heading2')" class="px-4 py-2 bg-blue-500 text-white rounded">H2</button>
                <button wire:click="addBlock('heading3')" class="px-4 py-2 bg-blue-500 text-white rounded">H3</button>
                <button wire:click="addBlock('text')" class="px-4 py-2 bg-blue-500 text-white rounded">Text</button>
                <button wire:click="addListItem()" class="px-4 py-2 bg-blue-500 text-white rounded">List Item</button>
                <button wire:click="addBlock('video')" class="px-4 py-2 bg-blue-500 text-white rounded">Video</button>
                <button type="button"
                    @click="
                                let youtubeLink = prompt('Paste YouTube video link:');
                                if (youtubeLink) {
                                    $wire.addVideoBlock(youtubeLink);
                                }
                            "
                    class="px-4 py-2 bg-blue-500 text-white rounded">Paste YouTube Link</button>
                <button wire:click="updateMaterial"
                    class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md">
                    Save Material
                </button>
            </div>
        </div>
    </div>
</div>
