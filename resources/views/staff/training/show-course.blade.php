<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

<body class="font-sans antialiased bg-gray-50 text-white">

    <x-banner />

    <div class="min-h-screen">
        @livewire('navigation-menu')

        <!-- Hero Section -->
        <div class="relative w-full h-80 bg-black">
            <img src="{{ asset($training->image) }}" class="w-full h-full object-cover opacity-50"
                alt="{{ $training->title }}">
            <div class="absolute inset-0 flex flex-col justify-center px-10">
                <a href="{{ route('training.courses') }}" class="text-gray-200 text-sm mb-3">← Back to Courses</a>
                <h1 class="text-4xl font-bold">{{ $training->title }}</h1>
                <p class="text-gray-200 text-lg mt-2">{{ $training->description }}</p>
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
            <div class="col-span-3 bg-gray-100 p-6 rounded-lg border">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Course Content</h2>
                <div x-data="{
                    activeAccordion: '',
                    setActiveAccordion(id) {
                        this.activeAccordion = (this.activeAccordion == id) ? '' : id
                    }
                }"
                    class="relative w-full mx-auto overflow-hidden text-sm font-normal bg-white border border-gray-200 divide-y divide-gray-200 rounded-lg">

                    @foreach ($training->materials as $index => $chapter)
                        <div x-data="{ id: 'accordion-{{ $index }}' }" class="cursor-pointer group">
                            <!-- Accordion Header -->
                            <button @click="setActiveAccordion(id)"
                                class="flex items-center justify-between w-full p-4 text-left select-none group-hover:underline">
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ $chapter->material_name }}
                                </span>
                                <svg class="w-4 h-4 text-gray-600 duration-200 ease-out"
                                    :class="{ 'rotate-180': activeAccordion == id }" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>

                            <!-- Accordion Content -->
                            <div x-show="activeAccordion==id" x-collapse x-cloak>
                                <div class="p-4 pt-0 text-gray-700 dark:text-gray-300 opacity-80">
                                    <p class="text-gray-700 dark:text-gray-300 opacity-80">
                                        {{ $chapter->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <!-- Instructor Card -->
            <div class="col-span-1 h-min bg-gray-100 p-6 rounded-lg border grow-0">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Instructor</h2>
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
                        <h3 class="text-lg font-semibold text-gray-800">{{ $training->trainer->first_name }}
                            {{ $training->trainer->last_name }}</h3>
                        <p class="text-gray-600">{{ $training->trainer->email }}</p>
                    </div>
                </div>
                <p class="text-gray-300 mt-4">{{ $training->trainer->bio }}</p>
            </div>
        </div>
    </div>

    @stack('modals')
    @livewireScripts
</body>

</html>
