@php use Carbon\Carbon; @endphp
<div class="bg-white h-auto dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-4">
    <div class="flex items-center justify-between mb-2">
        <button wire:click="previousMonth"
                class="text-gray-600 dark:text-gray-300 hover:text-accent dark:hover:text-accent focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                      clip-rule="evenodd"/>
            </svg>
        </button>
        <flux:heading>My Calendar - {{ $currentDate->format('F Y') }}</flux:heading>
        <button wire:click="nextMonth"
                class="text-gray-600 dark:text-gray-300 hover:text-accent dark:hover:text-accent focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                      clip-rule="evenodd"/>
            </svg>
        </button>
    </div>

    <!-- Days grid -->
    <div class="grid grid-cols-7 gap-1 mt-4">
        @php
            $daysInMonth = $currentDate->daysInMonth;
            $currentMonthData = collect($activityData)->filter(function ($day) use ($currentDate) {
                $date = Carbon::parse($day['date']);
                return $date->month == $currentDate->month && $date->year == $currentDate->year;
            })->keyBy(function ($day) {
                return Carbon::parse($day['date'])->day;
            });
        @endphp

        @foreach (range(1, $daysInMonth) as $day)
            @php
                $dayData = $currentMonthData->get($day, ['date' => $currentDate->copy()->setDay($day)->toDateString(), 'courses' => []]);
                $date = Carbon::parse($dayData['date']);
                $courseCount = isset($dayData['courses']) ? count($dayData['courses']) : 0;
                $coursesTooltip = isset($dayData['courses']) ? implode(', ', array_unique($dayData['courses'])) : 'No courses';
            @endphp
            <flux:tooltip content="{{ $date->format('d-M-Y') }}: {{ $courseCount }} {{ $coursesTooltip }}">
                <div
                    class="w-8 h-8 rounded flex items-center border justify-center text-xs {{ $date->isToday() ? 'ring-2 text-accent-content ring-accent-content' : '' }} {{ isset($dayData['courses']) && count($dayData['courses']) > 0 ? 'bg-green-400' : '' }} {{ isset($dayData['courses']) && count($dayData['courses']) > 0 ? 'text-white dark:text-white' : 'text-gray-700 dark:text-gray-300' }}"
                >
                    {{ $day }}
                </div>
            </flux:tooltip>
        @endforeach
    </div>
</div>
