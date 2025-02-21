<div class="dark:bg-gray-900 p-6">
    <div class="mb-9">
        <h1 class="font-bold text-lg text-gray-900 dark:text-gray-100">
            Your Training
            <a href={{ route('my.trainings') }} class="text-orange-500 text-sm">({{ $courseCount }})</a>
        </h1>

        <div class="flex my-3 justify-start items-center ">
            @if ($enrolledCourses->isNotEmpty())
            @livewire('staff.my-trainings')

            @else
                <div
                    class=" bg-white dark:bg-gray-800 border dark:border-gray-700 p-12 rounded-3xl h-auto dark:hover:bg-gray-700 transition duration-300 ease-in-out">
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
        <div>

        </div>
    </div>
</div>
