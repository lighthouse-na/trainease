<?php

namespace App\Livewire\CustomComponents;

use App\Models\Training\Enrollment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActivityGraph extends Component
{
    public $userId;
    public $activityData = [];

    public function mount()
    {
        $this->userId = Auth::user()->id;
        $this->loadActivityData();
    }

    public function loadActivityData()
{
    // Get the date ranges when the user's enrolled courses are active
    $enrollments = Enrollment::where('user_id', $this->userId)
        ->with('courses') // Changed from 'courses' to 'course' assuming singular relationship
        ->get();

    // Create a collection of all active dates
    $activeDates = collect();

    foreach ($enrollments as $enrollment) {
        // Check if course exists and has valid dates
        if ($enrollment->courses && $enrollment->courses->start_date && $enrollment->courses->end_date) {
            $startDate = Carbon::parse($enrollment->courses->start_date->toDateString());
            $endDate = Carbon::parse($enrollment->courses->end_date->toDateString());

            // Generate all dates between start and end date
            $currentDate = clone $startDate;
            while ($currentDate->lte($endDate)) {
                $dateString = $currentDate->toDateString();

                if (!$activeDates->has($dateString)) {
                    $activeDates->put($dateString, ['date' => $dateString, 'count' => 1]);
                } else {
                    // If the date already exists, increment the count
                    $currentValue = $activeDates->get($dateString);
                    $currentValue['count']++;
                    $activeDates->put($dateString, $currentValue);
                }

                $currentDate->addDay();
            }
        }
    }

    $data = $activeDates->values()->toArray();

    // If no enrollments, prepare empty data array
    if (empty($data)) {
        $data = [];
    }

    // Convert array to associative array indexed by date
    $dataByDate = collect($data)->keyBy('date')->toArray();

    // Get current year's start date and number of days
    $yearStart = Carbon::now()->startOfYear();
    $daysInYear = Carbon::now()->isLeapYear() ? 366 : 365;

    // Format data for the graph (current year only)
    $this->activityData = collect(range(0, $daysInYear - 1))->map(function ($day) use ($dataByDate, $yearStart) {
        $date = $yearStart->copy()->addDays($day)->toDateString();

        return [
            'date' => $date,
            'count' => isset($dataByDate[$date]) ? $dataByDate[$date]['count'] : 0,
        ];
    })->values();
}



    public function render()
    {
        return view('livewire.custom-components.activity-graph');
    }
}
