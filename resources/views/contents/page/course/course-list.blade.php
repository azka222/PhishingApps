@extends('layouts.employee-master')

@section('content')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Course Lists</h1>

            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="course_status" class="mb-1 block text-xs md:text-sm font-medium">Status</label>
                        <select id="course_status" name="course_status" onchange="()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="0">All</option>
                            <option value="1">Completed</option>
                            <option value="2">On Going</option>
                            <option value="3">No Progress</option>

                        </select>
                    </div>

                </div>
                <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                    <div class="flex md:flex-row flex-col items-start md:items-center mb-4 md:mb-0">
                        <label for="show" class="mr-2 text-xs md:text-sm font-medium mb-2 md:mb-0">Show</label>
                        <select id="show" name="show" onchange=""
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange=""
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class=" min-w-38 overflow-x-auto md:min-w-full">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-1">
                            <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-4">
                                <h2 class="text-lg font-semibold">Course Name</h2>
                                <div class="py-4">
                                    <img src="{{ asset('storage/course/thumbnail/thumbnail.jpg') }}" alt="Thumbnail"
                                        class=" w-full h-32 object-cover rounded-md">
                                </div>
                               
                                <p class="text-sm text-gray-400">Total Material: 10</p>
                                <p class="text-sm text-gray-400">Total Quiz: 5</p>
                                <div class="flex justify-end pt-4 gap-2">
                                    <button
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 flex items-center">Description</button>

                                    <button
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">View</button>

                                </div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-4">
                                <h2 class="text-lg font-semibold">Course Name</h2>
                                <div class="py-4">
                                    <img src="{{ asset('storage/course/thumbnail/thumbnail.jpg') }}" alt="Thumbnail"
                                        class=" w-full h-32 object-cover rounded-md">
                                </div>
                               
                                <p class="text-sm text-gray-400">Total Material: 10</p>
                                <p class="text-sm text-gray-400">Total Quiz: 5</p>
                                <div class="flex justify-end pt-4 gap-2">
                                    <button
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 flex items-center">Description</button>

                                    <button
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">View</button>

                                </div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-4">
                                <h2 class="text-lg font-semibold">Course Name</h2>
                                <div class="py-4">
                                    <img src="{{ asset('storage/course/thumbnail/thumbnail.jpg') }}" alt="Thumbnail"
                                        class=" w-full h-32 object-cover rounded-md">
                                </div>
                               
                                <p class="text-sm text-gray-400">Total Material: 10</p>
                                <p class="text-sm text-gray-400">Total Quiz: 5</p>
                                <div class="flex justify-end pt-4 gap-2">
                                    <button
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 flex items-center">Description</button>

                                    <button
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">View</button>

                                </div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-4">
                                <h2 class="text-lg font-semibold">Course Name</h2>
                                <div class="py-4">
                                    <img src="{{ asset('storage/course/thumbnail/thumbnail.jpg') }}" alt="Thumbnail"
                                        class=" w-full h-32 object-cover rounded-md">
                                </div>
                               
                                <p class="text-sm text-gray-400">Total Material: 10</p>
                                <p class="text-sm text-gray-400">Total Quiz: 5</p>
                                <div class="flex justify-end pt-4 gap-2">
                                    <button
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 flex items-center">Description</button>

                                    <button
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">View</button>

                                </div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-4">
                                <h2 class="text-lg font-semibold">Course Name</h2>
                                <div class="py-4">
                                    <img src="{{ asset('storage/course/thumbnail/thumbnail.jpg') }}" alt="Thumbnail"
                                        class=" w-full h-32 object-cover rounded-md">
                                </div>
                               
                                <p class="text-sm text-gray-400">Total Material: 10</p>
                                <p class="text-sm text-gray-400">Total Quiz: 5</p>
                                <div class="flex justify-end pt-4 gap-2">
                                    <button
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 flex items-center">Description</button>

                                    <button
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">View</button>

                                </div>
                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="bg-white dark:bg-gray-700 shadow-md rounded-xl p-4">
                                <h2 class="text-lg font-semibold">Course Name</h2>
                                <div class="py-4">
                                    <img src="{{ asset('storage/course/thumbnail/thumbnail.jpg') }}" alt="Thumbnail"
                                        class=" w-full h-32 object-cover rounded-md">
                                </div>
                               
                                <p class="text-sm text-gray-400">Total Material: 10</p>
                                <p class="text-sm text-gray-400">Total Quiz: 5</p>
                                <div class="flex justify-end pt-4 gap-2">
                                    <button
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 flex items-center">Description</button>

                                    <button
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">View</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="flex items-center flex-column flex-col md:flex-row justify-between p-4"
                    aria-label="Table navigation">
                    <span
                        class="mb-4 md:mb-0 text-xs md:text-sm font-normal text-gray-500 dark:text-gray-400 block w-full md:inline md:w-auto">Showing
                        <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">0</span> -
                            <span id="numberLastItem">0</span></span> of
                        <span id="totalTemplatesCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                    </span>
                    <ul id="pagination-page-button"
                        class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
