<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Training Request Form -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border dark:border-gray-700 shadow-lg md:col-span-2">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Request Training</h2>

            @if (session()->has('message'))
                <div
                    class="p-3 mb-4 text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900 border border-green-500 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="submit">
                <div class="mb-4">
                    <label for="training_title"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Training Title</label>
                    <input type="text" wire:model.defer="training_title" id="training_title" required
                        class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring focus:ring-blue-500">
                    @error('training_title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="title"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                    <input type="text" wire:model.defer="title" id="title" required
                        class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring focus:ring-blue-500">
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea wire:model.defer="description" id="description" required
                        class="w-full p-3 border rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-200 focus:ring focus:ring-blue-500"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <x-button type="submit"
                    class="p-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                    Submit Request
                </x-button>
            </form>
        </div>

        <!-- Training Requests List -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl border dark:border-gray-700 shadow-lg">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Your Training Requests</h2>

            @if ($requests->isEmpty())
                <p class="text-gray-600 dark:text-gray-400">No training requests submitted yet.</p>
            @else
                <div class="space-y-4">
                    @foreach ($requests as $request)
                        <div
                            class="p-4 border dark:border-gray-600 rounded-lg flex justify-between items-center bg-gray-100 dark:bg-gray-700 hover:shadow-lg transition">
                            <div>
                                <h3 class="font-semibold text-md text-gray-900 dark:text-gray-100">{{ $request->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $request->description }}</p>
                                <p class="text-sm mt-2">
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">Status:</span>
                                    <span
                                        class="px-2 py-1 text-xs font-medium rounded-lg
                                        @if ($request->status == 'pending') bg-yellow-200 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-200
                                        @elseif($request->status == 'approved') bg-green-200 text-green-800 dark:bg-green-700 dark:text-green-200
                                        @else bg-red-200 text-red-800 dark:bg-red-700 dark:text-red-200 @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </p>
                            </div>
                            <button wire:click="deleteRequest({{ $request->id }})"
                                class="text-red-600 dark:text-red-300 hover:text-red-800 dark:hover:text-red-400 transition">
                                Delete
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
