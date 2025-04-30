<?php

use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {
    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function with(): array
    {
        return [
            'users' => User::query()
                ->when($this->search, function ($query, $search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                })

                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10)
        ];
    }
};
?>

<div>
    <x-skillharbor.layout heading="{{ __('My Staff JCP Status') }}"
        subheading="{{ __('Check if your supervisees have Job Competency Profiles and create them.') }}">

        <div class="flex justify-between items-center mb-6">
            <div class="flex space-x-2">
                <flux:input wire:model="search" icon="magnifying-glass" placeholder="Search users..." />
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg border dark:border-gray-700 mb-4">
            <div class="flex justify-between items-center mb-3">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-medium">{{ $users->total() }}</span> Supervisees |
                    <span class="font-medium">{{ $users->filter(fn($user) => $user->jcps)->count() }}</span> Completed JCPs
                </div>
                @php
                    $completionPercentage = $users->total() > 0
                        ? ($users->filter(fn($user) => $user->jcps)->count() / $users->total()) * 100
                        : 0;
                @endphp
                <span class="text-sm font-medium text-accent">{{ number_format($completionPercentage, 1) }}%</span>
            </div>

            <div class="space-y-2">
                <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                    <div class="bg-accent h-2 rounded-full transition-all duration-500"
                        style="width: {{ $completionPercentage }}%"></div>
                </div>
                <div class="text-xs {{ $completionPercentage == 100 ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                    @if($completionPercentage == 100)
                        ✓ Department ready for skills audit
                    @else
                        ⚠ {{ number_format(100 - $completionPercentage, 1) }}% of JCPs pending completion
                    @endif
                </div>
            </div>
        </div>

        <div class="relative h-auto flex-1 overflow-hidden rounded-lg">
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg border dark:border-gray-700 mt-4">
                <table class="w-full whitespace-nowrap text-sm">
                    <thead>
                        <tr class="bg-gradient-to-r from-accent to-accent-content text-white">
                            <th class="px-4 py-3 text-left font-medium">Name</th>
                            <th class="px-4 py-3 text-left font-medium">Email</th>
                            <th class="px-4 py-3 text-left font-medium">JCP Status</th>
                            <th class="px-4 py-3 text-left font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-700">
                                <td class="px-4 py-3 font-medium dark:text-gray-300">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center mr-3">
                                            <flux:avatar name="{{ $user->name }}" color="auto" color:seed="{{ $user->id }}"/>
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 dark:text-gray-300">
                                    <span class="text-gray-600 dark:text-gray-400">{{ $user->email }}</span>
                                </td>
                                <td class="px-4 py-3 dark:text-gray-300">
                                    @if($user->jcps)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800/20 dark:text-yellow-400">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 dark:text-gray-300">
                                    <a href="{{ route('skill-harbor.directories.jcps.manage', ['user' => $user->id]) }}"
                                        class="inline-flex items-center px-3 py-1 text-sm rounded-md bg-accent/10 text-accent hover:bg-accent hover:text-white transition-colors duration-200">
                                        {{ $user->jcps ? 'Edit JCP' : 'Create JCP' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No users found</h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Try adjusting your search.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </x-skillharbor.layout>
</div>
