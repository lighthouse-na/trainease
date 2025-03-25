<?php

namespace App\Livewire\CustomComponents;

use App\Models\Training\Enrollment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActivityGraph extends Component
{
    /**
     * @var int|null $userId
     * @var array<int, mixed> $activityData
     * @var mixed $currentDate
     */
    public int|null $userId;
    public mixed $activityData = [];
    public mixed $currentDate;

    /**
     * @return void
     */
    public function mount(): void
    {
        $this->userId = Auth::user()?->id;
        $this->currentDate = Carbon::now();
        $this->loadActivityData();
    }

    /**
     * @return void
     */
    public function previousMonth(): void
    {
        $this->currentDate->subMonth();
        $this->loadActivityData();
    }

    /**
     * @return void
     */
    public function nextMonth(): void
    {
        $this->currentDate->addMonth();
        $this->loadActivityData();
    }

    /**
     * @return void
     */
    public function loadActivityData(): void
    {
        /**
         * @var array<int, Enrollment> $enrollments
         */
        $enrollments = Enrollment::where('user_id', $this->userId)
            ->with('courses') // Changed from 'courses' to 'course' assuming singular relationship
            ->get();

        // Create a collection of all active dates with course names
        $activeDates = collect();

        foreach ($enrollments as $enrollment) {
            // Check if course exists and has valid dates
            if ($enrollment->courses) {
                $startDate = Carbon::parse($enrollment->courses->start_date->toDateString());
                $endDate = Carbon::parse($enrollment->courses->end_date->toDateString());
                $courseName = $enrollment->courses->course_name;

                // Generate all dates between start and end date
                $currentDay = clone $startDate;
                while ($currentDay->lte($endDate)) {
                    $dateString = $currentDay->toDateString();

                    if (!$activeDates->has($dateString)) {
                        $activeDates->put($dateString, [
                            'date' => $dateString,
                            'courses' => [$courseName],
                        ]);
                    } else {
                        // If the date already exists, add the course name to the array
                        $currentValue = $activeDates->get($dateString);
                        $currentValue['courses'][] = $courseName;
                        $activeDates->put($dateString, $currentValue);
                    }

                    $currentDay->addDay();
                }
            }
        }

        // Convert to array format

        $this->activityData = $activeDates->values()->toArray();

        // If no enrollments, prepare empty data array
        if (empty($this->activityData)) {
             $this->activityData = [];
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.custom-components.activity-graph');
    }
}
