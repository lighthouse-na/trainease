<div class="dark:bg-gray-900 min-h-screen p-6">
    <div class="mb-9">
        <h1 class="font-bold text-lg text-gray-900 dark:text-gray-100">
            Your Training
            <a href={{ route('my.trainings') }} class="text-orange-500 text-sm">({{ $courseCount }})</a>
        </h1>

        <div class="flex my-3 justify-start items-center">
            @if ($enrolledCourses->isNotEmpty())
                @foreach ($enrolledCourses as $course)
                    @php
                        $progress = Auth::user()->calculateProgress($course->training->id);
                    @endphp

                    <div class="flex-shrink-0 w-1/3 min-w-[300px] p-3">
                        <div
                            class="bg-white dark:bg-gray-800 rounded-3xl hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300 ease-in-out shadow-md overflow-hidden">
                            <div class="flex flex-col justify-between h-full ">

                                <img src="{{ asset($course->training->image) }}"
                                    class="w-full h-40 object-cover rounded-t-xl hover:scale-105 transition duration-300 ease-in-out"
                                    alt="{{ $course->training->title }}">

                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 line-clamp-1">{{ $course->training->title }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 line-clamp-2">{{ $course->training->description }}</p>

                                    @php
                                        $progress = min(
                                            100,
                                            round(Auth::user()->calculateProgress($course->training->id)),
                                        );
                                    @endphp

                                    <div class="mt-4">
                                        <div class="relative pt-1">
                                            <div class="flex justify-between text-xs text-gray-900 dark:text-gray-300">
                                                <span>Course Progress:</span>
                                                <span>{{ $progress }}%</span>
                                            </div>
                                            <div class="h-1 overflow-hidden bg-gray-200 dark:bg-gray-600 rounded">
                                                <div style="width: {{ $progress }}%"
                                                    class="h-full rounded bg-orange-400"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('start.course', Crypt::encrypt($course->training->id)) }}"
                                        class="mt-6 flex items-center justify-center gap-2 px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-full hover:bg-orange-700 transition duration-300 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                        Continue Learning
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div
                    class=" bg-white dark:bg-gray-800 border dark:border-gray-700 p-12 rounded-3xl h-64 dark:hover:bg-gray-700 transition duration-300 ease-in-out">
                    <h1 class="font-bold text-3xl text-gray-800 dark:text-gray-100">Enroll in your first Training</h1>
                    <p class="text-xs text-gray-500 dark:text-gray-400 my-6">
                        Explore and add your first training course to get started. TrainEase offers a variety of
                        trainings and tutorials for you to learn and improve.
                    </p>
                    <a href="{{ route('training.courses') }}"
                        class="p-2 border  dark:border-gray-500 rounded-lg text-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 hover:bg-gray-200 transition duration-300 ease-in-out">
                        Explore Training Courses
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
