@extends('layouts.master')
@section('title', 'Sending Profiles')
@section('content')
@include('contents.modal.sending-profile.add-sending-profile-modal')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Sending Profiles</h1>
                <div>
                    <button onclick="showAddSendingProfileModal()"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Add
                        Profile</button>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-xs">
                    <div>
                        <label for="status"
                            class="mb-1 mt-4 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status" onchange="getSendingProfile()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex p-4 justify-between items-center mt-8">
                <div class="flex items-center">
                    <label for="show" class="mr-2 text-sm font-medium">Show</label>
                    <select id="show" name="show" onchange="getSendingProfile()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <input type="text" id="search" name="search" onchange="getSendingProfile()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search...">
                </div>
            </div>
            <div class="p-4 min-w-32 overflow-x-auto md:min-w-full">
                <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                    <thead class="bg-gray-300 dark:bg-gray-700">
                        <tr
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            <th scope="col" class="p-4">Profile Name</th>
                            <th scope="col" class="p-4">Username</th>
                            <th scope="col" class="p-4">Host</th>
                            <th scope="col" class="p-4">From Address</th>
                            <th scope="col" class="p-4">Ignore Certificate</th>
                            <th scope="col" class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-sending-profile-tbody"
                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                    </tbody>
                </table>
            </div>
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4"
                aria-label="Table navigation">
                <span
                    class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing
                    <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">0</span> - <span
                            id="numberLastItem">0</span></span> of
                    <span id="totalTemplatesCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                </span>
                <ul id="page-button-sending-profile-company" class="inline-flex space-x-2 rtl:space-x-reverse text-sm h-8">

                </ul>
            </nav>
        </div>
    </div>

    <script>
        function showAddSendingProfileModal(){
            showModal('add-sending-profile-modal');
        }
    </script>
@endsection
