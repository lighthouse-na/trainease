<?php

use Livewire\Volt\Component;
use App\Models\Training\Course;
use App\Models\UserDetail;
use \Illuminate\Database\Eloquent\Collection as EloquentCollection;

new class extends Component {
    public array $usersInStemCourses = [];
    public EloquentCollection $femaleUsersInStemCourses;
    public int $femalePercentage = 0;
    public int $malePercentage = 0;
    public int $percentageDifference = 0;
    public string $courseName = ''; // Course name should be set dynamically
    // Filter properties
    public string $filterType = ''; // Default value
    public string $selectedQuarter = '';
    public string $selectedMonth = '';
    public string $selectedYear = '';
    public string $startDate = '';
    public string $endDate = '';

    public bool $showFilterDropdown = false;

    public function mount(): void
    {
        $this->fetchUsersInStemCourses();
        $this->calculateGenderMetrics();
    }

    private function fetchUsersInStemCourses(): void
    {
        $this->usersInStemCourses = [
            'female' => UserDetail::where('gender', 'female')
                ->whereHas('user.enrolledCourses', function ($query) {
                    $query->where('is_stem', true);
                })
                ->with('user.enrolledCourses')
                ->get(),
            'male' => UserDetail::where('gender', 'male')
                ->whereHas('user.enrolledCourses', function ($query) {
                    $query->where('is_stem', true);
                })
                ->with('user.enrolledCourses')
                ->get(),
        ];
        $this->femaleUsersInStemCourses = $this->usersInStemCourses['female'];
    }

    private function calculateGenderMetrics(): void
    {
        $femaleCount = $this->usersInStemCourses['female']->count();
        $maleCount = $this->usersInStemCourses['male']->count();
        $totalUsers = $femaleCount + $maleCount;
        if ($totalUsers > 0) {
            $this->femalePercentage = ($femaleCount / $totalUsers) * 100;
            $this->malePercentage = ($maleCount / $totalUsers) * 100;
            $this->percentageDifference = abs($this->femalePercentage - $this->malePercentage);
        }
    }

    public function filterData(): void
    {
        $query = UserDetail::query();
        switch ($this->filterType) {
            case 'quarter':
                $quarters = [
                    'Q1' => [1, 3],
                    'Q2' => [4, 6],
                    'Q3' => [7, 9],
                    'Q4' => [10, 12],
                ];
                if (!isset($quarters[$this->selectedQuarter])) {
                    session()->flash('error', 'Invalid or missing quarter selection.');
                    return;
                }
                $range = $quarters[$this->selectedQuarter];
                $query->whereHas('user.enrolledCourses', function ($q) use ($range) {
                    $q->whereBetween('start_date', [
                        now()->setMonth($range[0])->startOfMonth(),
                        now()->setMonth($range[1])->endOfMonth(),
                    ]);
                });
                break;
            case 'month':
                if (empty($this->selectedMonth)) {
                    session()->flash('error', 'Please select a valid month.');
                    return;
                }
                $query->whereHas('user.enrolledCourses', function ($q) {
                    $q->whereMonth('start_date', $this->selectedMonth);
                });
                break;
            case 'year':
                if (empty($this->selectedYear)) {
                    session()->flash('error', 'Please select a valid year.');
                    return;
                }
                $query->whereHas('user.enrolledCourses', function ($q) {
                    $q->whereYear('start_date', $this->selectedYear);
                });
                break;
            case 'custom':
                if (empty($this->startDate) || empty($this->endDate)) {
                    session()->flash('error', 'Please provide a valid date range.');
                    return;
                }
                $query->whereHas('user.enrolledCourses', function ($q) {
                    $q->whereBetween('start_date', [$this->startDate, $this->endDate]);
                });
                break;
        }
        $this->usersInStemCourses = [
            'female' => $query->where('gender', 'female')->with('user.enrolledCourses')->get(),
            'male' => $query->where('gender', 'male')->with('user.enrolledCourses')->get(),
        ];
        $this->femaleUsersInStemCourses = $this->usersInStemCourses['female'];
        $this->calculateGenderMetrics();
    }

    public function toggleFilterDropdown(): void
    {
        $this->showFilterDropdown = !$this->showFilterDropdown;
    }
};
?>
<div class="dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                Women in STEM : {{ Auth::user()->trainerCourses->first()->course_name ?? 'Your Course' }}
            </h2>

            <div x-data="{ showFilters: false }" class="relative">
                <flux:button
                    @click="showFilters = !showFilters"
                    class="btn btn-sm btn-primary flex items-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
                        />
                    </svg>
                    Filter Options
                </flux:button>

                <div
                    x-show="showFilters"
                    @click.away="showFilters = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute top-full right-0 mt-2 w-94 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg z-10"
                    style="display: none;"
                >
                    <div class="p-4">
                        <label for="filterType" class="block font-medium text-gray-700 dark:text-gray-300">Filter
                            By:</label>
                        <select wire:model.live="filterType" id="filterType"
                                class="mt-2 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select Filter</option>
                            <option value="quarter">Quarter</option>
                            <option value="month">Month</option>
                            <option value="year">Year</option>
                            <option value="custom">Custom Range</option>
                        </select>

                        @if($filterType === 'quarter')
                            <label for="selectedQuarter" class="block mt-4 text-gray-700 dark:text-gray-300">Select
                                Quarter:</label>
                            <select wire:model.live="selectedQuarter" id="selectedQuarter"
                                    class="mt-2 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select Quarter</option>
                                <option value="Q1">Q1 (Jan - Mar)</option>
                                <option value="Q2">Q2 (Apr - Jun)</option>
                                <option value="Q3">Q3 (Jul - Sep)</option>
                                <option value="Q4">Q4 (Oct - Dec)</option>
                            </select>
                        @elseif($filterType === 'month')
                            <label for="selectedMonth" class="block mt-4 text-gray-700 dark:text-gray-300">Select
                                Month:</label>
                            <select wire:model.live="selectedMonth" id="selectedMonth"
                                    class="mt-2 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Select Month</option>
                                @foreach(range(1, 12) as $month)
                                    <option
                                        value="{{ $month }}">{{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                                @endforeach
                            </select>
                            <label for="selectedYear" class="block mt-4 text-gray-700 dark:text-gray-300">Select
                                Year:</label>
                            <input type="number" wire:model.live="selectedYear" id="selectedYear"
                                   class="mt-2 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   min="2000" max="{{ now()->year }}">
                        @elseif($filterType === 'custom')
                            <label for="startDate" class="block mt-4 text-gray-700 dark:text-gray-300">Start
                                Date:</label>
                            <input type="date" wire:model.live="startDate" id="startDate"
                                   class="mt-2 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <label for="endDate" class="block mt-4 text-gray-700 dark:text-gray-300">End Date:</label>
                            <input type="date" wire:model.live="endDate" id="endDate"
                                   class="mt-2 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @endif

                        <flux:button wire:click="filterData" variant="primary" class="w-full mt-4">
                            Apply Filter
                        </flux:button>

                    </div>
                </div>
            </div>
        </div>
        {{--   does this gray beneath check nxa ?.....{ughh answer here     --}}
        <div class="mb-6 bg-gradient-to-br from-gray-300 to-[#66cfb7] text-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold mb-2">Gender Distribution</h3>
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full bg-pink-400 mr-2"></div>
                    <span>Female: <strong class="text-xl">{{ number_format($femalePercentage, 2) }}%</strong></span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 rounded-full bg-blue-400 mr-2"></div>
                    <span>Male: <strong class="text-xl">{{ number_format($malePercentage, 2) }}%</strong></span>
                </div>
            </div>
            @if($femalePercentage !== null && $malePercentage !== null)
                <p class="mt-3 text-sm italic text-gray-700">
                    Difference: {{ number_format(abs($femalePercentage - $malePercentage), 2) }}%
                </p>
            @endif
        </div>

        <div>

            @if($femaleUsersInStemCourses->isEmpty())
                <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700">
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No female users found</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No female users are enrolled in this
                            course based on the current filter.</p>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700">
                    <table class="w-full whitespace-nowrap text-sm">
                        <thead>
                        <tr class="bg-gradient-to-r from-accent to-accent-content text-white">
                            <th class="px-4 py-3 text-left font-medium rounded-tl-lg">Name</th>
                            <th class="px-4 py-3 text-left font-medium">Email</th>
                            <th class="px-4 py-3 text-left font-medium">Phone</th>
                            <th class="px-4 py-3 text-left font-medium rounded-tr-lg">Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($femaleUsersInStemCourses as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                <td class="px-4 py-3 font-medium dark:text-gray-300">{{ $user->user->name }}</td>
                                <td class="px-4 py-3 dark:text-gray-300">{{ $user->user->email }}</td>
                                <td class="px-4 py-3 dark:text-gray-300">{{ $user->phone_number ?? 'N/A' }}</td>
                                <td class="px-4 py-3 dark:text-gray-300">{{ $user->address ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>


{{-- the higher you are on the table based on the count of curses(by that trainer) your enrolled in,--}}
{{--extra column for rank--}}
{{--extra colmun for number of courses enrolled in(for the current trainers courses)--}}
{{--fix bug where if you clikc fltrer without having chosen a filter the shits just fucks u the percentage--}}
