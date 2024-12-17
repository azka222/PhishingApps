@extends('layouts.master')
@section('title', 'User Setting')

@section('content')
    <div class="flex justify-center h-screen pt-28 pe-4 ps-4 bg-gray-50 dark:bg-gray-800">
        <div class="w-4/5 h-4/5 p-4 grid grid-cols-3 bg-gray-200 dark:bg-gray-600 rounded-xl gap-4">
            <div class="col-span-1 border-e-2 border-e-gray-900 dark:border-e-gray-100">
                <div id="default-sidebar" class="" aria-label="Sidebar">
                    <div class="px-3 py-4 overflow-y-auto ">
                        <div class="p-2">
                            <div id="button-setting-profile" onclick="handleSidebar('profile')"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span class="ms-3">Profile</span>
                            </div>
                        </div>
                        <div class="p-2">
                            <div id="button-setting-security" onclick="handleSidebar('security')"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="ms-3">Security</span>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-span-2">
                <fieldset id="profile-content" class="h-full p-4">
                    <div class="w-full h-full bg-gray-200 dark:bg-gray-600 rounded-xl">
                        <div class="flex flex-col gap-4 h-full">
                            <div class="w-full h-1/5 bg-gray-300 dark:bg-gray-700 rounded-xl">
                                <div class="flex flex-row justify-start ps-4 gap-8  h-full">
                                    <div class="h-full flex items-center">
                                        <img src="{{ asset('image/user.png') }}" class="w-20 h-20 rounded-full">
                                    </div>
                                    <div class="h-full flex gap-4 items-center">
                                        <div>
                                            <h1 class="text-xl font-semibold dark:text-white">User Name</h1>
                                            <p class="text-sm dark:text-white">Company Name</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full h-4/5 bg-gray-300 dark:bg-gray-700 rounded-xl">
                                <div class="grid grid-cols-2 p-4 gap-4">
                                    <div class="ps-2 pt-2 col-span-1">
                                        <h1 class="text-lg dark:text-white font-semibold">First Name</h1>
                                        <h2 id="first_name_display" class="text-md pt-2 dark:text-white">John</h2>
                                    </div>
                                    <div class="ps-2 pt-2 col-span-1">
                                        <h1 class="text-lg dark:text-white font-semibold">Last Name</h1>
                                        <h2 id="last_name_display" class="text-md pt-2 dark:text-white">Doe</h2>
                                    </div>
                                    <div class="ps-2 pt-2 col-span-1">
                                        <h1 class="text-lg dark:text-white font-semibold">Phone Number</h1>
                                        <h2 id="phone_number_display" class="text-md pt-2 dark:text-white">087822172006</h2>
                                    </div>
                                    <div class="ps-2 pt-2 col-span-1">
                                        <h1 class="text-lg dark:text-white font-semibold">Gender</h1>
                                        <h2 id="gender_display" class="text-md pt-2 dark:text-white">Male</h2>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </fieldset>
            </div>


        </div>
    </div>


    <script>
        let active = ' bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white';
        let inactive =
            ' bg-gray-300 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-900 dark:text-white';

        $(document).ready(function() {
            firstRender();
        })

        function firstRender() {
            $(".side-button").addClass(inactive).removeClass(active);
            $("#button-setting-profile").removeClass(inactive).addClass(active);
        }

        function handleSidebar(content) {
            $(".side-button").removeClass(active).addClass(inactive);
            $("#button-setting-" + content).removeClass(inactive).addClass(active);
        }
    </script>
@endsection
