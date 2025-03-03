@php

    $enrollments = App\Models\Training\Enrollment::where('user_id', Auth::user()->id)
        ->with('courses')
        ->paginate(3);
    $progress = 50;
    $stats = [
        [
            'title' => 'Courses Completed',
            'value' => '12',
            'trend' => '+23.1%',
            'trendUp' => true,
        ],
        [
            'title' => 'Active Courses',
            'value' => '5',
            'trend' => '+14.8%',
            'trendUp' => true,
        ],
        [
            'title' => 'Average Score',
            'value' => '87.5%',
            'trend' => '+4.3%',
            'trendUp' => true,
        ],
        [
            'title' => 'Total Hours',
            'value' => '42.5',
            'trend' => '+17.2%',
            'trendUp' => true,
        ],
    ];

@endphp
<x-layouts.app>

    <div class="flex h-auto w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-2">
                <div class="flex items-center gap-2">
                    <flux:select size="sm" class="">
                        <option>Last 7 days</option>
                        <option>Last 14 days</option>
                        <option selected>Last 30 days</option>
                        <option>Last 60 days</option>
                        <option>Last 90 days</option>
                    </flux:select>

                    <flux:subheading class="max-md:hidden whitespace-nowrap">compared to</flux:subheading>

                    <flux:select size="sm" class="max-md:hidden">
                        <option selected>Previous period</option>
                        <option>Same period last year</option>
                        <option>Last month</option>
                        <option>Last quarter</option>
                        <option>Last 6 months</option>
                        <option>Last 12 months</option>
                    </flux:select>
                </div>

                <flux:separator vertical class="max-lg:hidden mx-2 my-2" />

                <div class="max-lg:hidden flex justify-start items-center gap-2">
                    <flux:subheading class="whitespace-nowrap">Filter by:</flux:subheading>

                    <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">Amount
                    </flux:badge>
                    <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg"
                        class="max-md:hidden">Status</flux:badge>
                    <flux:badge as="button" variant="pill" color="zinc" icon="plus" size="lg">More
                        filters...</flux:badge>
                </div>
            </div>


        </div>


        <div class="flex gap-6 mb-6">
            @foreach ($stats as $stat)
                <div
                    class="relative flex-1 rounded-lg px-6 py-4 bg-zinc-50 dark:bg-zinc-700 {{ $loop->iteration > 1 ? 'max-md:hidden' : '' }}  {{ $loop->iteration > 3 ? 'max-lg:hidden' : '' }}">
                    <flux:subheading>{{ $stat['title'] }}</flux:subheading>

                    <flux:heading size="xl" class="mb-2">{{ $stat['value'] }}</flux:heading>

                    <div
                        class="flex items-center gap-1 font-medium text-sm @if ($stat['trendUp']) text-green-600 dark:text-green-400 @else text-red-500 dark:text-red-400 @endif">
                        <flux:icon :icon="$stat['trendUp'] ? 'arrow-trending-up' : 'arrow-trending-down'"
                            variant="micro" /> {{ $stat['trend'] }}
                    </div>

                    <div class="absolute top-0 right-0 pr-2 pt-2">
                        <flux:button icon="ellipsis-horizontal" variant="subtle" size="sm" />
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div
        class="relative h-auto flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
        <h1 class="text-black font-bold">My Trainings</h1>

        <div class="flex flex-col">

            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-neutral-200">
                            <thead>
                                <tr class="text-neutral-500">
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Course</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Progress</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Status</th>
                                    <th class="px-5 py-3 text-xs font-medium text-right uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-neutral-200">
                                @forelse ($enrollments as $enrollment)
                                    <tr class="text-neutral-800 hover:bg-slate-50 dark:hover:bg-neutral-800 cursor-pointer"
                                        onclick="window.location='{{ route('course.show', ['course_id' => $enrollment->courses->id, 'enrollment_id' => $enrollment->id]) }}'">
                                        <td
                                            class="px-5 py-4 text-sm font-medium whitespace-nowrap dark:text-accent text-accent-content">
                                            {{ $enrollment->courses->course_name }}
                                        </td>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap">
                                            <div class="relative pt-1">
                                                <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full mt-1">
                                                    <div style="width: {{ $progress }}%"
                                                        class="h-full bg-teal-600 dark:bg-teal-400 rounded-full transition-all duration-500 ease-in-out">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap">
                                            <span
                                                class="text-xs font-medium text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900 rounded-full px-3 py-1 border border-green-600">
                                                {{ $enrollment->status }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm font-medium text-right whitespace-nowrap">
                                            <a class="text-blue-600 hover:text-blue-700" href="#">Edit</a>
                                        </td>
                                    </tr>


                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-10 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <flux:icon icon="academic-cap" class="w-12 h-12 mb-3 text-gray-300" />
                                                <flux:heading size="lg">You have not enrolled in any course
                                                </flux:heading>
                                                <p class="mt-2 text-gray-500">Start your learning journey by enrolling
                                                    in a course.</p>
                                                <a href="{{ route('training.coursespage') }}"
                                                    class="mt-4 px-4 py-2 bg-accent-content hover:bg-accent text-accent-foreground rounded-md transition-colors">
                                                    Browse Courses
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>

            <div class="mt-6">
                {{ $enrollments->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
