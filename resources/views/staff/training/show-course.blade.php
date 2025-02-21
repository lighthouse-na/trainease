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
            <div class="absolute top-6 right-10 p-4 rounded-xl  text-center">
                <div class="absolute top-6 right-10 p-4 rounded-xl text-center">
                    @livewire('training.components.enroll-button', ['training' => $training])
                </div>

            </div>

        </div>

        <!-- Course Content & Instructor Section -->
        <div class="grid grid-cols-4 gap-6 p-10">
            <!-- Course Content -->
            <div class="col-span-3 dark:bg-gray-800 p-6 rounded-xl  dark:border-gray-700">
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Course Content</h2>
                <div x-data="{ activeAccordion: '' }"
                    class="relative w-full mx-auto overflow-hidden border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700 rounded-xl bg-white">
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
                class="col-span-1 bg-white dark:bg-gray-800 p-6 rounded-xl shadow border dark:border-gray-700">
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
                <div class="flex items-center divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($training->enrolledUsers as $user)
                        <div class=" w-full py-2">
                            <div class="flex items-center">

                                <div class="ml-4">
                                    <div x-data="{
                                        hoverCardHovered: false,
                                        hoverCardDelay: 600,
                                        hoverCardLeaveDelay: 500,
                                        hoverCardTimout: null,
                                        hoverCardLeaveTimeout: null,
                                        hoverCardEnter () {
                                            clearTimeout(this.hoverCardLeaveTimeout);
                                            if(this.hoverCardHovered) return;
                                            clearTimeout(this.hoverCardTimout);
                                            this.hoverCardTimout = setTimeout(() => {
                                                this.hoverCardHovered = true;
                                            }, this.hoverCardDelay);
                                        },
                                        hoverCardLeave () {
                                            clearTimeout(this.hoverCardTimout);
                                            if(!this.hoverCardHovered) return;
                                            clearTimeout(this.hoverCardLeaveTimeout);
                                            this.hoverCardLeaveTimeout = setTimeout(() => {
                                                this.hoverCardHovered = false;
                                            }, this.hoverCardLeaveDelay);
                                        }
                                    }" class="relative" @mouseover="hoverCardEnter()" @mouseleave="hoverCardLeave()">
                                    <a href="#_" class="hover:underline bg-gray-100 p-1 my-2 rounded-xl ">@<span>{{ $user->last_name }}{{ substr($user->first_name, 0, 1) }}</span></a>
                                    <div x-show="hoverCardHovered" class="absolute top-0 w-[365px] max-w-lg mt-5 z-30 -translate-x-1/2 translate-y-3 left-1/2" x-cloak>
                                        <div x-show="hoverCardHovered" class="w-[full] h-auto bg-white space-x-3 p-5 flex items-start rounded-md shadow-sm border border-neutral-200/70" x-transition>
                                            <div class="w-14 h-14 flex items-center justify-center rounded-full bg-red-600 text-white font-bold text-lg p-4">
                                                {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name, 0, 1)) }}
                                            </div>
                                            <div class="relative">
                                                <p class="mb-1 font-bold">{{$user->first_name}} {{$user->last_name}}</p>
                                                <p class="mb-1 text-sm text-gray-600">{{$user->email}}</p>
                                                <p class="flex items-center space-x-1 text-xs text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                                      </svg>
                                                    <span>Joined {{$user->created_at->toFormattedDateString()}}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
