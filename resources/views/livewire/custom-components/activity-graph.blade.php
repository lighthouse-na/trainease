<div class="bg-white dark:bg-gray-800 rounded-xl border dark:border-gray-700 p-4">
    <flux:heading>My Activity Graph</flux:heading>

    <!-- Month labels -->
    <div class="grid grid-cols-53 gap-1 text-xs text-gray-500 dark:text-gray-400 mb-1">
        @php
            $months = [];
            $currentMonth = null;
            // We're processing 365 days (0-364) from the activityData collection
            foreach ($activityData as $index => $day) {
                $date = \Carbon\Carbon::parse($day['date']);
                $month = $date->format('M');
                $dayOfWeek = $date->dayOfWeek;

                // Calculate the correct column for this date
                $weekIndex = floor($index / 7);

                // Add month label on first day of month
                if ($currentMonth !== $month) {
                    $months[$weekIndex] = $month;
                    $currentMonth = $month;
                }
            }
        @endphp

        @foreach(range(0, 52) as $week)
            <div class="text-center">{{ $months[$week] ?? '' }}</div>
        @endforeach
    </div>

    <div class="grid grid-cols-53 gap-1 my-3">
        @php $weekIndex = 0; $dayIndex = 0; @endphp
        @foreach ($activityData as $day)
            @if($dayIndex % 7 === 0 && $dayIndex > 0)
                @php $weekIndex++; @endphp
            @endif
            <flux:tooltip content="{{ \Carbon\Carbon::parse($day['date'])->format('d-M-Y') }}: {{ $day['count'] }} activities">
                <div
                    class="w-4 h-4 rounded bg-{{ $day['count'] > 5 ? 'green-700' : ($day['count'] > 2 ? 'green-500' : ($day['count'] > 0 ? 'green-300' : 'gray-200')) }} dark:bg-{{ $day['count'] > 5 ? 'green-600' : ($day['count'] > 2 ? 'green-500' : ($day['count'] > 0 ? 'green-700' : 'gray-700')) }}"
                ></div>
            </flux:tooltip>
            @php $dayIndex++; @endphp
        @endforeach
    </div>
</div>
