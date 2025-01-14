@extends('layouts.master')
@section('title', 'Landing Page')

@section('content')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Landing Page Templates</h1>

            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="capture_passwords" class="mb-1 block text-xs md:text-sm font-medium">Capture
                            Password</label>
                        <select id="capture_passwords" name="capture_passwords" onchange="getLandingPage()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="2">All</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>

                        </select>
                    </div>
                    <div>
                        <label for="capture_credentials"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Capture
                            Credentials</label>
                        <select id="capture_credentials" name="capture_credentials" onchange="getLandingPage()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="2">All</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                    <div class="flex md:flex-row flex-col items-start md:items-center mb-4 md:mb-0">
                        <label for="show" class="mr-2 text-xs md:text-sm font-medium mb-2 md:mb-0">Show</label>
                        <select id="show" name="show" onchange="getLandingPage()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getLandingPage()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class=" min-w-32 overflow-x-auto md:min-w-full">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                <th scope="col" class="p-4">Name</th>
                                <th scope="col" class="p-4">Capture Credentials</th>
                                <th scope="col" class="p-4">Capture Password</th>
                                <th scope="col" class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody id="list-page-tbody"
                            class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                        </tbody>
                    </table>
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

            < </div>
        </div>

        <script>
            $(document).ready(function() {
                getLandingPage();
            });

            function getLandingPage(page = 1) {
                let show = $("#show").val();
                let search = $("#search").val();
                let capture_credentials = $("#capture_credentials").val();
                let capture_passwords = $("#capture_passwords").val();
                $.ajax({
                    url: "{{ route('getLandingPage') }}" + "?page=" + page,
                    type: "GET",
                    data: {
                        show: show,
                        search: search,
                        page: page,
                        capture_credentials: capture_credentials,
                        capture_passwords: capture_passwords
                    },
                    success: function(response) {
                        console.log(response)
                        $("#list-page-tbody").empty();
                        $("#pagination-page-button").empty();
                        let landingPage = response.landingPage;
                        Object.keys(landingPage).forEach(function(key) {
                            let value = landingPage[key];
                            let credentials = '';
                            let password = '';
                            if (value.capture_credentials != 0) {
                                credentials = `<div class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">
                                                True
                                            </div>`;
                            } else {
                                credentials = `<div class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 inline-block">
                                                False
                                            </div>`;
                            }
                            if (value.capture_passwords != 0) {
                                password = `<div class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">
                                                True
                                            </div>`;
                            } else {
                                password = `<div class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 inline-block">
                                                False
                                            </div>`;
                            }

                            $("#list-page-tbody").append(`
                            <tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4">${value.name}</td>
                                <td class="p-4">${credentials}</td>
                                <td class="p-4">${password}</td>
                                <td class="p-4">
                                    <button onclick="showLandingPage(${value.id})" class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Show Preview</button>
                                </td>
                            </tr>
                        `);


                        });
                        paginationLandingPage("#pagination-page-button", response.pageCount, response.currentPage);
                        $("#numberFirstItem").text(
                            response.targetTotal != 0 ? (page - 1) * $("#show").val() + 1 : 0
                        );
                        $("#numberLastItem").text(
                            (page - 1) * $("#show").val() + response.landingPage.length
                        );
                        $("#totalTemplatesCount").text(response.targetTotal);

                    }
                });
            }

            function showLandingPage(id) {
                window.open("{{ route('landingPagePreview', ['id' => '__ID__']) }}".replace('__ID__', id));
            }
        </script>
    @endsection
