@php
    $enrollments = App\Models\Training\Enrollment::where('user_id', Auth::user()->id)
        ->with('courses')
        ->paginate(3);
@endphp
<x-layouts.app>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @forelse ($enrollments as $enrollment)
            <a href="{{route('course.show', ['course_id' => $enrollment->courses->id, 'enrollment_id' => $enrollment->id])}}" class="block group">

                <div class="relative  overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">

                    {{-- Image at the top with hover zoom effect --}}
                    <div class="overflow-hidden">
                        <img src="{{ asset($enrollment->courses->course_image) }}"
                            class="w-full h-36 object-cover rounded-t-xl group-hover:scale-105 transition-transform duration-300 ease-in-out"
                            alt="{{ $enrollment->courses->course_name }}">
                    </div>

                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 line-clamp-1">
                            {{ $enrollment->courses->course_name }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                            {{ $enrollment->courses->course_description }}
                        </p>

                        {{-- Status Badge --}}
                        @if ($enrollment->status === 'completed')
                            <div class="flex mt-3">
                                <span
                                    class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900 rounded-full px-3 py-1 border border-green-600">
                                    Completed
                                </span>
                            </div>
                        @endif

                        @php
                            $progress = min(100, round(Auth::user()->calculateProgress($enrollment->courses->id)));
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
            @empty
            <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
            <flux:heading size="lg">You have not enrolled in any course</flux:heading>
            <flux:subheading>This information will be displayed publicly.</flux:subheading>
            <flux:button variant="primary" pointer>Courses</flux:button>

        </div>
            @endforelse

        </div>
        <div
            class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

</x-layouts.app>
