<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-6">
    <h1 class="font-bold text-2xl text-gray-900 dark:text-gray-100">Training Courses</h1>

    <div class="mb-9">
        @if (session()->has('success'))
            <div
                class="text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900 p-3 rounded-lg mb-4 border border-green-500">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900 p-3 rounded-lg mb-4 border border-red-500">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 my-3">
            @foreach ($trainings as $training)
                <a href="{{ route('training.show', Crypt::encrypt($training->id)) }}" class="block group">
                    <div
                        class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-2xl overflow-hidden shadow-md hover:shadow-lg transition duration-300 ease-in-out cursor-pointer">

                        {{-- Image with Hover Effect --}}
                        <div class="overflow-hidden">
                            <img src="{{ asset($training->image) }}"
                                class="w-full h-44 object-cover rounded-t-2xl group-hover:scale-105 transition-transform duration-300 ease-in-out"
                                alt="{{ $training->title }}">
                        </div>

                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $training->title }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">
                                {{ $training->description }}
                            </p>
                            <div class="flex justify-between items-center mt-4 space-x-4">
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">Trainer:</span>
                                    <span class="ml-1 text-sm font-medium text-gray-800 dark:text-gray-200">
                                        {{ $training->trainer->first_name }} {{ $training->trainer->last_name }}
                                    </span>
                                </div>
                                <span class="px-3 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200 rounded-full">
                                    {{ $training->training_type }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="mt-6">
        {{ $trainings->links('pagination::tailwind') }}
    </div>
</div>
