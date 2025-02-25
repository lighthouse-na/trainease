<div class="flex min-h-screen w-full bg-gray-100 dark:bg-gray-900">
    <!-- Sidebar -->
    <aside class="bg-white dark:bg-gray-800 w-64 p-4 border-r dark:border-gray-700 overflow-y-auto">
        <h2 class="text-sm text-gray-500 mb-2">Trainease</h2>
        <nav>
            <ul class="space-y-2">
                <li><a href="#"
                        class="flex items-center p-2 rounded bg-gray-200 dark:bg-gray-700 text-xs"><x-fluentui-grid-24-o
                            class="mr-4 h-5 w-5" />
                        Dashboard</a></li>
                <li><a href="#"
                        class="flex items-center p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700  text-xs"><x-fluentui-mail-all-read-24-o
                            class="mr-4 h-5 w-5" />
                        Inbox</a></li>
                <li><a href="#"
                        class="flex items-center p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700  text-xs"><x-fluentui-calendar-ltr-24-o
                            class="mr-4 h-5 w-5 " />

                        Calendar</a></li>
                <li><a href="#"
                        class="flex items-center p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700  text-xs"><x-fluentui-shifts-activity-24-o
                            class="mr-4 h-5 w-5" />
                        Activity Feed</a></li>

            </ul>
            <h2 class="text-sm text-gray-500 my-2">Other</h2>

            <ul class="space-y-2">
                <li><a href="#"
                        class="flex items-center p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700  text-xs"><x-fluentui-text-bullet-list-square-settings-20-o
                            class="mr-4 h-5 w-5" />
                        Modules</a></li>
                <li><a href="#"
                        class="flex items-center p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700  text-xs"><x-fluentui-people-community-24-o
                            class="mr-4 h-5 w-5" />
                        Students</a></li>
                <li><a href="#"
                        class="flex items-center p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700  text-xs"><x-fluentui-data-usage-edit-24-o
                            class="mr-4 h-5 w-5" />
                        Skillharbor</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
            Hi there, {{ auth()->user()->first_name }}!
        </h1>
        {{-- Cards --}}
        <div class="grid grid-cols-4 gap-4 mt-10">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Students</h2>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">100</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Courses</h2>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">10</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Enrollments</h2>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">1000</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Cost</h2>
                <p class="text-3xl font-bold text-gray-800 dark:text-gray-200">$100,000</p>
            </div>
        </div>
        {{-- Upcoming Classes Section --}}
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-10">Upcoming Classes</h2>
        <h3>You have 3 upcoming classes</h3>
        <div class="grid grid-cols-3 gap-6 mt-3">
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Class 1</h2>
                <p class="text-sm text-gray-800 dark:text-gray-200">Date: 12th August 2021</p>
                <p class="text-sm text-gray-800 dark:text-gray-200">Time: 10:00 AM</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Class 2</h2>
                <p class="text-sm text-gray-800 dark:text-gray-200">Date: 12th August 2021</p>
                <p class="text-sm text-gray-800 dark:text-gray-200">Time: 10:00 AM</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Class 3</h2>
                <p class="text-sm text-gray-800 dark:text-gray-200">Date: 12th August 2021</p>
                <p class="text-sm text-gray-800 dark:text-gray-200">Time: 10:00 AM</p>
            </div>
        </div>

        {{-- Classroom Section --}}
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mt-10">Classrooms</h2>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Training Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Duration
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Trainer
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Training 1
                        </th>
                        <td class="px-6 py-4">
                            12th August 2021
                        </td>
                        <td class="px-6 py-4">
                            2 hours
                        </td>
                        <td class="px-6 py-4">
                            John Doe
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-2" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-2" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Training 2
                        </th>
                        <td class="px-6 py-4">
                            13th August 2021
                        </td>
                        <td class="px-6 py-4">
                            3 hours
                        </td>
                        <td class="px-6 py-4">
                            Jane Smith
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-3" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-3" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Training 3
                        </th>
                        <td class="px-6 py-4">
                            14th August 2021
                        </td>
                        <td class="px-6 py-4">
                            1.5 hours
                        </td>
                        <td class="px-6 py-4">
                            Michael Brown
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span class="font-semibold text-gray-900 dark:text-white">1-3</span> of <span class="font-semibold text-gray-900 dark:text-white">3</span></span>
            </nav>
        </div>
    </main>
</div>
