<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
        <!-- Training Request Form -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg border span-col-2">
            <h2 class="text-lg font-semibold mb-4">Request Training</h2>

            @if (session()->has('message'))
                <div class="p-3 mb-4 text-green-700 bg-green-100 rounded-lg">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="submit">
                <div class="mb-4 ">
                    <label for="training_id" class="block text-sm font-medium text-gray-700">Training</label>
                    <select wire:model.defer="training_id" id="training_id" required class="w-full p-2 border rounded-lg">
                        <option value="">Select a Training</option>
                        @foreach ($trainings as $training)
                            <option value="{{ $training->id }}">{{ $training->title }}</option>
                        @endforeach
                    </select>
                    @error('training_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" wire:model.defer="title" id="title" required class="w-full p-2 border rounded-lg">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model.defer="description" id="description" required class="w-full p-2 border rounded-lg"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <x-button type="submit" class="p-2 rounded-lg hover:bg-blue-700">
                    Submit Request
                </x-button>
            </form>
        </div>

        <!-- Training Requests List -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg border">
            <h2 class="text-lg font-semibold mb-4">Your Training Requests</h2>

            @if ($requests->isEmpty())
                <p class="text-gray-500">No training requests submitted yet.</p>
            @else
                <div class="space-y-4">
                    @foreach ($requests as $request)
                        <div class="p-4 border rounded-lg flex justify-between items-center">
                            <div>
                                <h3 class="font-semibold text-md">{{ $request->title }}</h3>
                                <p class="text-gray-600 text-sm">{{ $request->description }}</p>
                                <p class="text-sm mt-2">
                                    <span class="font-semibold">Status:</span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-lg
                                        @if($request->status == 'pending') bg-yellow-200 text-yellow-800
                                        @elseif($request->status == 'approved') bg-green-200 text-green-800
                                        @else bg-red-200 text-red-800
                                        @endif">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </p>
                            </div>
                            <button wire:click="deleteRequest({{ $request->id }})" class="text-red-600 hover:text-red-800">
                                🗑 Delete
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


</div>
