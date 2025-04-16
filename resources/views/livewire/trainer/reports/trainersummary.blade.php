<?php

use Livewire\Volt\Component;
use App\Models\Training\Reports\Summary;

new class extends Component {
    //

    public $summary;

    public function mount(){
        $this->summary = Summary::where('user_id', Auth::user()->id)->with('course', 'user')->get();

    }

    public $period = '';
    public $startDate;
    public $endDate;
    public $exportFormat = 'pdf';

    public function exportReport()
    {
        // Validate inputs for custom date range
        if ($this->period === 'custom') {
            $this->validate([
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate',
            ]);
        }

        // Get filtered data based on period selection
        $query = Summary::where('user_id', Auth::user()->id)->with('course', 'user');

        switch ($this->period) {
            case 'this_month':
                $query->whereHas('course', function($q) {
                    $q->whereMonth('start_date', now()->month)
                      ->whereYear('start_date', now()->year);
                });
                break;
            case 'last_month':
                $query->whereHas('course', function($q) {
                    $q->whereMonth('start_date', now()->subMonth()->month)
                      ->whereYear('start_date', now()->subMonth()->year);
                });
                break;
            case 'this_year':
                $query->whereHas('course', function($q) {
                    $q->whereYear('start_date', now()->year);
                });
                break;
            case 'custom':
                $query->whereHas('course', function($q) {
                    $q->whereBetween('start_date', [$this->startDate, $this->endDate]);
                });
                break;
        }

        $data = $query->get();

        // Format data for CSV export
        $csvData = [];
        foreach ($data as $row) {
            $csvData[] = [
                'App No' => $row->id,
                'Course Name' => $row->course->course_name,
                'Type' => $row->course->course_type,
                'Institution' => 'Dummy Institution',
                'Email' => $row->user->email,
                'Phone' => $row->user->user_detail->phone_number,
                'Start Date' => $row->course->start_date->format('Y-m-d'),
                'End Date' => $row->course->end_date->format('Y-m-d'),
                'Facilitator Cost' => $row->facilitator_cost,
                'Assessment Cost' => $row->assessment_cost,
                'Certification Cost' => $row->certification_cost,
                'Travel Cost' => $row->travel_cost,
                'Accommodation Cost' => $row->accommodation_cost,
                'Other Cost' => $row->other_cost,
                'Total Cost' => $row->total_cost
            ];
        }

        return $this->downloadArrayToCsv($csvData, 'training-summary-' . now()->format('Y-m-d'));
    }

    public function downloadArrayToCsv($array, $filename) {
        if (empty($array)) {
            session()->flash('error', 'No data to export');
            return null;
        }

        $output = '';

        // Add headers
        $output .= implode(",", array_keys($array[0])) . "\n";

        // Add data rows
        foreach ($array as $row) {
            // Escape values that might contain commas
            $escapedRow = array_map(function($value) {
                return '"' . str_replace('"', '""', $value) . '"';
            }, $row);

            $output .= implode(",", $escapedRow) . "\n";
        }

        // Set headers for download
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ];

        // Return the response with the CSV data
        return response($output, 200, $headers);
    }
}; ?>

<div>
    <div class="bg-white rounded-lg  p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">{{Auth::user()->name}}'s Training Summary Report</h2>

            <div x-data="{ showFilters: false }" class="relative">
            <flux:button @click="showFilters = !showFilters" class="btn btn-sm btn-primary flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Export Report
            </flux:button>

            <div x-show="showFilters" @click.away="showFilters = false" class="absolute right-0 mt-2 bg-white rounded-lg p-4 z-10 w-64" style="display: none;">
                <form wire:submit.prevent="exportReport">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                    <select wire:model="period" class="select select-sm w-full border-gray-300 rounded-md">
                    <option value="">Select period</option>
                    <option value="this_month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="this_year">This Year</option>
                    <option value="custom">Custom Range</option>
                    </select>
                </div>

                <div class="mb-3" x-data="{ customRange: @entangle('period').defer === 'custom' }">
                    <div x-show="customRange">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" wire:model="startDate" class="input input-sm w-full border-gray-300 rounded-md">
                        </div>
                        <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" wire:model="endDate" class="input input-sm w-full border-gray-300 rounded-md">
                        </div>
                    </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                    <select wire:model="exportFormat" class="select select-sm w-full border-gray-300 rounded-md">
                    <option value="csv">CSV</option>
                    </select>
                </div>

                <div class="flex flex-col gap-2">
                    <flux:button icon="document-arrow-down" type="submit" variant="primary" class="w-full">Export</flux:button>
                    @if (session()->has('error'))
                        <div class="text-sm text-red-600">{{ session('error') }}</div>
                    @endif
                </div>
                </form>
            </div>
            </div>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg border">
            <table class="w-full whitespace-nowrap text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-accent to-accent-content text-white">
                        <th class="px-4 py-3 text-left font-medium rounded-tl-lg">App No.</th>
                        <th class="px-4 py-3 text-left font-medium">Course Name</th>
                        <th class="px-4 py-3 text-left font-medium">Type</th>
                        <th class="px-4 py-3 text-left font-medium">Institution</th>
                        <th class="px-4 py-3 text-left font-medium">Contact</th>
                        <th class="px-4 py-3 text-left font-medium">Period</th>
                        <th class="px-4 py-3 text-right font-medium">Costs</th>
                        <th class="px-4 py-3 text-right font-medium rounded-tr-lg">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($summary as $row)
                    <tr class="hover:bg-gray-50 border-b border-gray-100">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium">{{ $row->course->course_name }}</td>
                        <td class="px-4 py-3">{{ $row->course->course_type }}</td>
                        <td class="px-4 py-3">Dummy Institution</td>
                        <td class="px-4 py-3">
                            <div class="text-sm">{{ $row->user->email }}</div>
                            <div class="text-xs text-gray-500">{{ $row->user->user_detail->phone_number }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm">{{ $row->course->start_date->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500">to {{ $row->course->end_date->format('M d, Y') }}</div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" class="text-blue-600 hover:text-blue-800"
                                    x-data="{}"
                                    x-on:click="$dispatch('open-modal', 'cost-details-{{ $loop->iteration }}')">
                                View Details
                            </button>

                            <!-- Modal -->
                            <div x-data="{ open: false }"
                                x-show="open"
                                x-on:open-modal.window="$event.detail == 'cost-details-{{ $loop->iteration }}' ? open = true : null"
                                x-on:close-modal.window="open = false"
                                x-on:keydown.escape.window="open = false"
                                x-transition.opacity
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90"
                                style="display: none;">
                                <div class="bg-white rounded-lg   p-6 w-full max-w-md">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium">Cost Breakdown</h3>
                                        <button x-on:click="open = false" class="text-gray-500 hover:text-gray-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between"><span>Facilitator:</span> <span>N${{ $row->facilitator_cost }}</span></div>
                                        <div class="flex justify-between"><span>Assessment:</span> <span>N${{ $row->assessment_cost }}</span></div>
                                        <div class="flex justify-between"><span>Certification:</span> <span>N${{ $row->certification_cost }}</span></div>
                                        <div class="flex justify-between"><span>Travel:</span> <span>N${{ $row->travel_cost }}</span></div>
                                        <div class="flex justify-between"><span>Accommodation:</span> <span>N${{ $row->accommodation_cost }}</span></div>
                                        <div class="flex justify-between"><span>Other:</span> <span>N${{ $row->other_cost }}</span></div>
                                        <div class="border-t pt-2 font-bold flex justify-between"><span>Total:</span> <span>N${{ $row->total_cost }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right font-bold">N${{ $row->total_cost }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($summary->isEmpty())
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No records found</h3>
            <p class="mt-1 text-sm text-gray-500">No training summary data is available at this time.</p>
        </div>
        @endif
    </div>
</div>
