<?php

use Livewire\Volt\Component;
use App\Models\Training\Reports\Summary;
use App\Exports\NTAClaimExport;
use Livewire\WithPagination;
new class extends Component {
    //
    use WithPagination;

    public function with(): array
    {
        return [
            'summary' => Summary::where('user_id', Auth::user()->id)->with('course', 'user')->cursorPaginate(20),
            ];
    }

    public function mount(){

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

        $rawData = $query->get();

        // Preprocess data for Excel/CSV format
        $processedData = [];
        $headers = [
            'Application Number',
            'Training or Course Name',
            'Delivery Type (Internal or External Training)',
            'Training Institution (Facilitator) Name',
            'Training Institution (Facilitator) Email',
            'Training Institution (Facilitator) Telephone',
            'Training Start Date (dd/mm/yyyy)',
            'Training End Date (dd/mm/yyyy)',
            'Training Facilitator Cost',
            'Training Material Cost',
            'Assessment Cost',
            'Certification Cost',
            'Travel Cost',
            'Accommodation Cost',
            'Subsistence and Travel Allowance',
            'Other Cost',
            'Total Cost',
        ];

        // Add headers as first row
        $processedData[] = $headers;

        foreach ($rawData as $index => $row) {
            $processedData[] = [
                $index + 1,
                $row->course->course_name,
                $row->course->course_type,
                'Dummy Institution', // Replace with actual data
                $row->user->email,
                $row->user->user_detail->phone_number,
                $row->course->start_date->format('d/m/Y'),
                $row->course->end_date->format('d/m/Y'),
                number_format($row->facilitator_cost, 2),
                number_format(0, 2),
                number_format($row->assessment_cost, 2),
                number_format($row->certification_cost, 2),
                number_format($row->travel_cost, 2),
                number_format($row->accommodation_cost, 2),
                number_format(0, 2),
                number_format($row->other_cost, 2),
                number_format($row->total_cost, 2),
            ];
        }

        // Handle export based on format
        switch ($this->exportFormat) {
            case 'excel':
            case 'csv':
                $extension = $this->exportFormat === 'excel' ? 'xlsx' : 'csv';
                return Excel::download(
                    new NTAClaimExport($processedData),
                    'training-summary-' . now()->format('Y-m-d') . '.' . $extension
                );

            default:
                session()->flash('error', 'Invalid export format');
                return null;
        }
    }
}; ?>

<div class="dark:bg-gray-900">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{Auth::user()->name}}'s Training Summary Report</h2>

            <div x-data="{ showFilters: false }" class="relative">
            <flux:button @click="showFilters = !showFilters" class="btn btn-sm btn-primary flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Export Report
            </flux:button>

            <div x-show="showFilters" @click.away="showFilters = false" class="absolute border right-0 mt-2 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-lg p-4 z-10 w-94" style="display: none;">
                <form wire:submit.prevent="exportReport">
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date Range</label>
                    <flux:select wire:model="period" class="select select-sm w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md">
                    <flux:select.option value="">Select period</flux:select.option>
                    <flux:select.option value="this_month">This Month</flux:select.option>
                    <flux:select.option value="last_month">Last Month</flux:select.option>
                    <flux:select.option value="this_year">This Year</flux:select.option>
                    <flux:select.option value="custom">Custom Range</flux:select.option>
                    </flux:select>
                </div>

                <div class="mb-4" x-data="{ customRange: false }">
                    <div x-effect="customRange = $wire.period === 'custom'"></div>

                    <div x-show="customRange" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100" class="mt-3">
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Please select date range</p>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <flux:input type="date" wire:model="startDate" label="Start Date" max="2999-12-31" class="input-xs dark:bg-gray-700 dark:text-gray-300" />
                                </div>
                                <div>
                                    <flux:input type="date" wire:model="endDate" label="End Date" max="2999-12-31" class="input-xs dark:bg-gray-700 dark:text-gray-300" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Format</label>
                    <flux:select. wire:model="exportFormat" class="select select-sm w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-md">
                    <flux:select.option value=" ">Select your export format</flux:select.option>
                    <flux:select.option value="excel">Excel</flux:select.option>
                    <flux:select.option value="csv">CSV</flux:select.option>
                    </flux:select.>
                </div>

                <flux:button icon="document-arrow-down" type="submit" variant="primary" class="w-full">Export</flux:button>
                </form>
            </div>
            </div>
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700">
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
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                        <td class="px-4 py-3 dark:text-gray-300">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium dark:text-gray-300">{{ $row->course->course_name }}</td>
                        <td class="px-4 py-3 dark:text-gray-300">{{ $row->course->course_type }}</td>
                        <td class="px-4 py-3 dark:text-gray-300">Dummy Institution</td>
                        <td class="px-4 py-3">
                            <div class="text-sm dark:text-gray-300">{{ $row->user->email }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $row->user->user_detail->phone_number }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm dark:text-gray-300">{{ $row->course->start_date->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">to {{ $row->course->end_date->format('M d, Y') }}</div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
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
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium dark:text-white">Cost Breakdown</h3>
                                        <button x-on:click="open = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="space-y-2 dark:text-gray-300">
                                        <div class="flex justify-between"><span>Facilitator:</span> <span>N${{ $row->facilitator_cost }}</span></div>
                                        <div class="flex justify-between"><span>Assessment:</span> <span>N${{ $row->assessment_cost }}</span></div>
                                        <div class="flex justify-between"><span>Certification:</span> <span>N${{ $row->certification_cost }}</span></div>
                                        <div class="flex justify-between"><span>Travel:</span> <span>N${{ $row->travel_cost }}</span></div>
                                        <div class="flex justify-between"><span>Accommodation:</span> <span>N${{ $row->accommodation_cost }}</span></div>
                                        <div class="flex justify-between"><span>Other:</span> <span>N${{ $row->other_cost }}</span></div>
                                        <div class="border-t dark:border-gray-600 pt-2 font-bold flex justify-between"><span>Total:</span> <span>N${{ $row->total_cost }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right font-bold dark:text-gray-300">N${{ $row->total_cost }}</td>
                    </tr>
                    @endforeach
                    <!-- Grand Total Row -->
                    @if(!$summary->isEmpty())
                    <tr class="bg-gray-100 dark:bg-gray-700 font-bold">
                        <td class="px-4 py-3 dark:text-gray-300" colspan="6">Grand Total</td>
                        <td class="px-4 py-3 text-right">
                            <button type="button" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                                    x-data="{}"
                                    x-on:click="$dispatch('open-modal', 'total-cost-details')">
                                View Details
                            </button>

                            <!-- Total Modal -->
                            <div x-data="{ open: false }"
                                x-show="open"
                                x-on:open-modal.window="$event.detail == 'total-cost-details' ? open = true : null"
                                x-on:close-modal.window="open = false"
                                x-on:keydown.escape.window="open = false"
                                x-transition.opacity
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90"
                                style="display: none;">
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium dark:text-white">Total Cost Breakdown</h3>
                                        <button x-on:click="open = false" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    <div class="space-y-2 dark:text-gray-300">
                                        <div class="flex justify-between"><span>Facilitator:</span> <span>N${{ $summary->sum('facilitator_cost') }}</span></div>
                                        <div class="flex justify-between"><span>Assessment:</span> <span>N${{ $summary->sum('assessment_cost') }}</span></div>
                                        <div class="flex justify-between"><span>Certification:</span> <span>N${{ $summary->sum('certification_cost') }}</span></div>
                                        <div class="flex justify-between"><span>Travel:</span> <span>N${{ $summary->sum('travel_cost') }}</span></div>
                                        <div class="flex justify-between"><span>Accommodation:</span> <span>N${{ $summary->sum('accommodation_cost') }}</span></div>
                                        <div class="flex justify-between"><span>Other:</span> <span>N${{ $summary->sum('other_cost') }}</span></div>
                                        <div class="border-t dark:border-gray-600 pt-2 font-bold flex justify-between"><span>Total:</span> <span>N${{ $summary->sum('total_cost') }}</span></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right dark:text-gray-300">N${{ $summary->sum('total_cost') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if($summary->isEmpty())
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No records found</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No training summary data is available at this time.</p>
        </div>
        @endif
        <div class="my-4">
            {{ $summary->links() }}
        </div>
    </div>
</div>
