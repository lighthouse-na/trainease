<div class="w-full py-6 px-64 overflow-y-auto dark:bg-gray-800">
    <div class="p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-200">{{$quiz->title}}</h1>

        @foreach ($question as $q)
            <div class="mb-8 bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                <div class="flex items-start mb-4">
                    <span class="bg-indigo-500 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3">
                        {{$loop->iteration}}
                    </span>
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-200">{{$q['question']}}</h3>
                </div>

                <div class="ml-11 space-y-3">
                    @foreach($q['options'] as $option)
                        <label class="flex items-center p-3 bg-white dark:bg-gray-600 rounded-lg cursor-pointer hover:bg-indigo-50 dark:hover:bg-gray-500 transition">
                            <input type="radio" name="q{{$loop->parent->iteration}}" class="form-radio h-5 w-5 text-indigo-600">
                            <span class="ml-3 text-gray-700 dark:text-gray-200">{{ $option }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="mt-6 flex justify-end">
            <button class="bg-indigo-500 text-white px-6 py-2 rounded-lg hover:bg-indigo-600 transition">
                Submit Quiz
            </button>
        </div>
    </div>
</div>
