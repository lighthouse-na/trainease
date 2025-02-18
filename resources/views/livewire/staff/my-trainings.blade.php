<div>
    @if ($enrollments->isEmpty())
        <p class="text-gray-600 dark:text-gray-400">You are not enrolled in any courses yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($enrollments as $enrollment)
                @if ($enrollment->status === 'approved' || $enrollment->status === 'completed')
                    <a href="{{ route('start.course', Crypt::encrypt($enrollment->training->id)) }}" class="block">
                        <div class="bg-white border overflow-hidden rounded-xl hover:bg-gray-50  transition">
                            {{-- Image at the top --}}
                            <img src="{{ asset($enrollment->training->image) }}"
                                class="w-full h-40 object-cover rounded-t-xl hover:scale-105 transition duration-300 ease-in-out"
                                alt="{{ $enrollment->training->title }}">
                            <div class="p-6">

                                <h3 class="text-lg font-semibold text-gray-900 line-clamp-1">{{ $enrollment->training->title }}</h3>
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $enrollment->training->description }}</p>
                                @if ($enrollment->status === 'completed')
                                    <div class="flex mt-2">
                                        <span
                                            class="text-xs text-green-600 bg-green-100 rounded-lg p-2 border border-green-600">Completed</span>

                                    </div>
                                @endif
                                @php
                                    $progress = min(
                                        100,
                                        round(Auth::user()->calculateProgress($enrollment->training->id)),
                                    );
                                @endphp

                                <div class="mt-4">
                                    <div class="relative pt-1">
                                        <div class="flex justify-between text-xs">
                                            <span>Course Progress:</span>
                                            <span>{{ $progress }}%</span>
                                        </div>
                                        <div class="h-1 overflow-hidden bg-gray-200 rounded">
                                            <div style="width: {{ $progress }}%" class="h-full bg-teal-600 rounded">
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
    @endif
</div>
