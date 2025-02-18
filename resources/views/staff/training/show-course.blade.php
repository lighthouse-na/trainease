<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $training->title }} | {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-200">
    <x-banner />

    <div class="min-h-screen">
        @livewire('navigation-menu')

        <!-- Hero Section -->
        <div class="relative w-full h-80 bg-gray-800 dark:bg-gray-700">
            <img src="{{ asset($training->image) }}" class="w-full h-full object-cover opacity-60 dark:opacity-40"
                alt="{{ $training->title }}">
            <div class="absolute inset-0 flex flex-col justify-center px-10">
                <a href="{{ route('training.courses') }}" class="text-gray-200 text-sm mb-3 hover:underline">← Back to
                    Courses</a>
                <h1 class="text-gray-100 text-4xl font-bold">{{ $training->title }}</h1>
                <p class="text-gray-300 text-lg mt-2">{{ $training->description }}</p>
            </div>
            <div class="absolute top-6 right-10 p-4 rounded-lg  text-center">
                <div class="absolute top-6 right-10 p-4 rounded-lg text-center">
                    @livewire('training.components.enroll-button', ['training' => $training])
                </div>

            </div>

        </div>

        <!-- Course Content & Instructor Section -->
        <div class="grid grid-cols-4 gap-6 p-10">
            <!-- Course Content -->
            <div class="col-span-3 bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700">
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Course Content</h2>
                <div x-data="{ activeAccordion: '' }"
                    class="relative w-full mx-auto overflow-hidden border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 rounded-lg">
                    @foreach ($training->materials as $index => $chapter)
                        <div x-data="{ id: 'accordion-{{ $index }}' }" class="cursor-pointer group">
                            <button @click="activeAccordion = (activeAccordion == id) ? '' : id"
                                class="flex items-center justify-between w-full p-4 text-left select-none">
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $chapter->material_name }}
                                </span>
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-300 duration-200"
                                    :class="{ 'rotate-180': activeAccordion == id }" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                            <div x-show="activeAccordion == id" x-collapse x-cloak>
                                <div class="p-4 pt-0 text-gray-700 dark:text-gray-300 opacity-80">
                                    <p>{{ $chapter->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Instructor Card -->
            <div
                class="col-span-1 overflow-y-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow border dark:border-gray-700">
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">Instructor</h2>
                <div class="flex items-center">
                    @if ($training->trainer->profile_photo_path)
                        <img src="{{ asset($training->trainer->profile_photo_path) }}"
                            class="w-14 h-14 object-cover rounded-full" alt="{{ $training->trainer->name }}">
                    @else
                        <div
                            class="w-14 h-14 flex items-center justify-center rounded-full bg-gray-700 text-white font-bold text-lg">
                            {{ strtoupper(substr($training->trainer->first_name, 0, 1)) }}{{ strtoupper(substr($training->trainer->last_name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            {{ $training->trainer->first_name }} {{ $training->trainer->last_name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $training->trainer->email }}</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mt-4">{{ $training->trainer->bio }}</p>
                <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200 mt-4">Enrolled Staff <span
                        class="text-orange-500 text-xs">({{ $training->enrolledUsers->count() }})
                    </span></h2>
                <div class="flex items-center">
                    @forelse ($training->enrolledUsers as $user)
                        <div class="border-b border-gray-200 dark:border-gray-700 w-full py-2">
                            <div class="flex items-center">

                                <div class="ml-4">
                                    <h3 class="text-xs font-semibold text-gray-800 dark:text-gray-200">
                                        {{ $user->first_name }} {{ $user->last_name }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                </div>

                            </div>
                        @empty
                    @endforelse

                </div>
            </div>

        </div>

        @stack('modals')
        @livewireScripts
</body>

</html>
