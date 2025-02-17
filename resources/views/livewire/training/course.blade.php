<div class="flex h-screen">
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
                            <span>50%</span>
                        </div>
                        <div class="h-1 overflow-hidden bg-gray-200 rounded">
                            <div style="width: 50%" class="h-full bg-teal-600 rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <h3 class="text-lg font-semibold mt-2">Course Material</h3>

                @foreach ($courseMaterials as $material)
                <a href="#"
                class="flex items-center text-sm border rounded-lg p-2 block mt-2 hover:text-gray-900 {{ $material->id % 2 == 0 ? 'bg-green-50 border-green-200 text-green-700' : 'bg-white border-gray-200 text-gray-700' }}">
                        <span class="flex justify-center items-center h-6 w-6 mr-3">
                            @if ($material->id % 2 == 0)
                                <!-- Example condition to alternate icons -->
                                <x-fas-check-circle class="h-4 w-4 text-green-600" />
                            @else
                                <x-fas-angle-right class="h-4 w-4" />
                            @endif
                        </span>
                        {{ $material->material_name }}
                    </a>
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
                    <p class="dark:text-gray-400 bg-red-100 border border-red-500 rounded-lg p-3">No quizzes available for this course.</p>

                @endforelse

            </div>

        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-bold">Course Content</h2>
        <p class="mt-4 text-gray-700">This is where course content will go.</p>

    </main>
</div>
