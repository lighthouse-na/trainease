<div>

    <div class="mb-9">
        <h1 class="font-bold text-lg">
            Your Training <a href={{ route('my.trainings') }}><span
                    class="text-orange-500 text-sm">({{ $courseCount }})</span> </a>
        </h1>
        <div class="flex my-3 justify-start items-center">
            @if ($enrolledCourses->isNotEmpty() )
                @foreach ($enrolledCourses as $course)
                    @php
                        // Calculate progress for the current training
                        $progress = Auth::user()->calculateProgress($course->training->id);
                    @endphp
                    <div class="flex-shrink-0 w-1/3 min-w-[300px] p-3"> <!-- Set a min-width for better visibility -->
                        <div
                            class="bg-white border border-gray-200 rounded-3xl h-auto hover:border transition duration-300 ease-in-out">
                            <div class="flex flex-col justify-between h-full flex-shrink-0">
                                <!-- Course Title -->
                                <div class="bg-white border overflow-hidden rounded-xl hover:bg-gray-50  transition">
                                    {{-- Image at the top --}}
                                    <img src="{{ asset($course->training->image) }}"
                                        class="w-full h-40 object-cover rounded-t-xl hover:scale-105 transition duration-300 ease-in-out"
                                        alt="{{ $course->training->title }}">
                                    <div class="p-6">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $course->training->title }}
                                        </h3>
                                        <p class="text-sm text-gray-500 mt-2">{{ $course->training->description }}</p>

                                        @php
                                            $progress = min(
                                                100,
                                                round(Auth::user()->calculateProgress($course->training->id)),
                                            );
                                        @endphp

                                        <div class="mt-4">
                                            <div class="relative pt-1">
                                                <div class="flex justify-between text-xs">
                                                    <span>Course Progress:</span>
                                                    <span>{{$progress}}%</span>
                                                </div>
                                                <div class="h-1 overflow-hidden bg-gray-200 rounded">
                                                    <div style="width: {{$progress}}%" class="h-full bg-teal-600 rounded">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('start.course', Crypt::encrypt($course->training->id)) }}"
                                            class="mt-6 flex items-center justify-center gap-2 px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-full border hover:bg-orange-700 transition duration-300 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                            Continue Learning
                                        </a>
                                    </div>

                                </div>
                                <!-- CTA Button -->

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div
                    class="bg-white border p-12 rounded-3xl h-64 hover:bg-gray-100 transition duration-300 ease-in-out">
                    <h1 class="font-bold text-3xl">Enroll in your first Training</h1>
                    <p class="text-xs text-gray-400 my-6">Explore and add your first training course to get started.
                        TrainEase offers a variety of trainings and tutorials for you to learn and improve.</p>
                    <a href="{{ route('training.courses') }}"
                        class="p-2 border border-black rounded-lg hover:bg-white transition duration-300 ease-in-out">
                        Explore Training Courses
                    </a>
                </div>
            @endif
        </div>
        {{-- <div class="mb-9">
            <h1 class="font-bold text-lg">
                Certifications
            </h1>
            <div class="flex grid grid-cols-3 gap-3 my-3">
                <div class="max-w-sm rounded-3xl overflow-hidden border bg-white ">
                    <div class="px-6 py-3 mt-6">
                        <div class="font-bold text-xl mb-2">Problem Solving (Basic)</div>
                        <button
                            class="p-2 my-6 border border-black rounded-lg hover:bg-white transition duration-300 ease-in-out ">Get
                            Certified
                        </button>

                    </div>
                </div>
                <div class="max-w-sm rounded-3xl overflow-hidden border bg-white ">
                    <div class="px-6 py-3 mt-6">
                        <div class="font-bold text-xl mb-2">Cyber Security (Basic)</div>
                        <button
                            class="p-2 my-6 border border-black rounded-lg hover:bg-white transition duration-300 ease-in-out ">Get
                            Certified</button>
                    </div>



                </div>
                <div class="max-w-sm rounded-3xl overflow-hidden border bg-white ">
                    <div class="px-6 py-3 mt-6">
                        <div class="font-bold text-xl mb-2">Introduction to Excel (Basic)</div>
                        <button
                            class="p-2 my-6 border border-black rounded-lg hover:bg-white transition duration-300 ease-in-out ">Get
                            Certified</button>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="">

            <div class="bg-white p-6 rounded-3xl border">
                <h2 class="text-2xl  font-bold mb-4">Train By Category</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                    <div class="bg-gradient-to-br from-orange-100 to-orange-300 p-4 text-slate-800 rounded-2xl">
                        <h1 class="font-bold">Technical</h1>
                        <h2 class="text-xs">Training Consultant: Dino Almirall</h2>
                    </div>
                    <div class="bg-gradient-to-br from-orange-100 to-orange-300 p-4 text-slate-800 rounded-2xl">
                        <h1 class="font-bold">Commercial & General</h1>
                        <h2 class="text-xs">Training Consultant: Johanna Haupindi</h2>

                    </div>
                    <div class="bg-gradient-to-br from-orange-100 to-orange-300 p-4 text-slate-800 rounded-2xl">
                        <h1 class="font-bold">
                            Information Technology</h1>
                        <h2 class="text-xs">Training Consultant: Vivian Malander</h2>
                    </div>

                </div>
            </div>
        </div> --}}

    </div>
