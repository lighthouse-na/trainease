<div class="flex h-screen w-full">
    <!-- Sidebar -->
    <aside class="bg-gray-50 w-92 p-4 border overflow-y-auto">
        <div class="mb-4">
            <div class="border rounded-lg p-4 bg-white">
                <h3 class="text-lg font-semibold">{{ $training->title }}</h3>

                @php
                    $progress = min(100, round(Auth::user()->calculateProgress($training->id)));
                @endphp

                <div class="mt-4">
                    <div class="relative pt-1">
                        <div class="flex justify-between text-xs">
                            <span>Course Progress:</span>
                            <span>{{ $progress }}%</span>
                        </div>
                        <div class="h-1 overflow-hidden bg-gray-200 rounded">
                            <div style="width: {{ $progress }}%" class="h-full bg-teal-600 rounded"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="">
                <h3 class="text-lg font-semibold mt-2">Course Material</h3>


                @foreach ($courseMaterials as $material)
                    <div class="flex items-center text-sm border rounded-lg p-2 block mt-2 hover:text-gray-900
        {{ $content->id === $material->id ? 'bg-blue-100 border-blue-500 text-blue-800 font-bold' : '' }}
        {{ in_array($material->id, $completedMaterials) ? 'bg-green-50 border-green-200 text-green-700' : 'bg-white border-gray-200 text-gray-700' }}"
                        wire:click="setActiveContent({{ $material->id }})">

                        <span class="flex justify-center items-center h-6 w-6 mr-3">
                            @if (in_array($material->id, $completedMaterials))
                                <x-fas-check-circle class="h-4 w-4 text-green-600" />
                            @elseif ($content->id === $material->id)
                                <x-fas-circle-notch class="h-4 w-4 text-blue-600 animate-spin" />
                            @else
                                <x-fas-angle-right class="h-4 w-4" />
                            @endif
                        </span>

                        {{ $material->material_name }}
                    </div>
                @endforeach



            </div>

            <div class="">
                <h3 class="text-lg font-semibold mt-2">Course Quizzes</h3>
                @forelse ($quizzes as $quiz)
                    <a href="#"
                        class="flex items-center text-sm border rounded-lg p-2 block mt-2 hover:text-gray-900 {{ $quiz->id % 2 == 0 ? 'bg-green-50 border-green-200 text-green-700' : 'bg-white border-gray-200 text-gray-700' }}">
                        <span class="flex justify-center items-center h-6 w-6 mr-3">
                            @if ($quiz->id % 2 == 0)
                                <!-- Example condition to alternate icons -->
                                <x-fas-check-circle class="h-4 w-4 text-green-600" />
                            @else
                                <x-fas-angle-right class="h-4 w-4" />
                            @endif
                        </span>
                        {{ $quiz->quiz_name }}
                    </a>
                @empty
                    <p class="dark:text-gray-400 bg-red-100 border border-red-500 rounded-lg p-3 mt-2">No quizzes
                        available
                        for this course.</p>
                @endforelse

            </div>

        </div>
    </aside>

    <!-- Main Content -->
    <div class="p-12 overflow-y-auto w-full">
        @if ($content)
            <h2 class="text-2xl font-bold">{{ $content->material_name }}</h2>

            <p class="mt-4 text-gray-700">{{ $content->material_description }}</p>
            <div class="">
                <article class="prose lg:prose-lg">
                    <x-markdown>
                        {!! $content->material_content !!}
                    </x-markdown>
                </article>

            </div>
            <div class="flex justify-end my-12">
                <button wire:click="loadPreviousMaterial"
                class="m-4 bg-gray-500 text-white px-4 py-2 rounded-lg disabled:opacity-50"
                {{ $content->id === $courseMaterials->first()->id ? 'disabled' : '' }}>
                <x-fas-angle-left class="text-white  h-3 w-3" />
            </button>

            <button wire:click="loadNextMaterial"
                class="m-4 bg-gray-500 text-white px-4 py-2 rounded-lg disabled:opacity-50"
                {{ $content->id === $courseMaterials->last()->id ? 'disabled' : '' }}>
                <x-fas-angle-right class="text-white h-3 w-3" />
            </button>

            </div>
        @else
            <p class="text-gray-700">No content selected.</p>
        @endif
    </div>
</div>
