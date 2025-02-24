<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
    @if ($enrollments->isEmpty())
        <p class="text-gray-600 dark:text-gray-400 text-center text-lg">
            You are not enrolled in any courses yet. Start learning today!
        </p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 ">
            @foreach ($enrollments as $enrollment)
                @if ($enrollment->status === 'approved' || $enrollment->status === 'completed')
                    <a href="{{ route('start.course', Hashids::encode($enrollment->training->id)) }}" class="block group">
                        <div class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-2xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 ease-in-out">

                            {{-- Image at the top with hover zoom effect --}}
                            <div class="overflow-hidden">
                                <img src="{{ asset($enrollment->training->image) }}"
                                    class="w-full h-40 object-cover rounded-t-2xl group-hover:scale-105 transition-transform duration-300 ease-in-out"
                                    alt="{{ $enrollment->training->title }}">
                            </div>

                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 line-clamp-1">
                                    {{ $enrollment->training->title }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                                    {{ $enrollment->training->description }}
                                </p>

                                {{-- Status Badge --}}
                                @if ($enrollment->status === 'completed')
                                    <div class="flex mt-3">
                                        <span class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900 rounded-full px-3 py-1 border border-green-600">
                                            Completed
                                        </span>
                                    </div>
                                @endif

                                @php
                                    $progress = min(100, round(Auth::user()->calculateProgress($enrollment->training->id)));
                                @endphp

                                {{-- Progress Bar --}}
                                <div class="mt-4">
                                    <div class="relative pt-1">
                                        <div class="flex justify-between text-xs text-gray-700 dark:text-gray-300">
                                            <span>Course Progress</span>
                                            <span>{{ $progress }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full mt-1">
                                            <div style="width: {{ $progress }}%"
                                                class="h-full bg-teal-600 dark:bg-teal-400 rounded-full transition-all duration-500 ease-in-out">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
        <div class="mt-6">
            {{ $enrollments->links('pagination::tailwind') }}
        </div>
    @endif
</div>
