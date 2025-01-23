@extends('layouts.master')
@section('title', 'Fischsim - User Setting')
@section('content')
    @include('contents.modal.user-setting.edit-profile-modal')
    @include('contents.modal.user-setting.otp-modal')
    @include('contents.modal.user-setting.edit-company-modal')
    @include('contents.modal.user-setting.create-role-modal')
    @include('contents.modal.user-setting.update-user-modal')
    @php
        $companyId = Auth::user()->company_id;
    @endphp
    <div class="min-h-screen dark:bg-gray-800">
        <div class="grid grid-cols-4 gap-2 md:gap-4 justify-center pt-8 lg:pt-28 pb-8 px-4 lg:px-28 ">
            <div class="col-span-4 lg:col-span-1 pe-0 md:pe-2 ">
                <div id="default-sidebar" class="" aria-label="Sidebar">
                    <div class="overflow-y-auto ">
                        <div class="mb-2">
                            <div id="button-setting-profile" onclick="handleSidebar('profile');getProfile()"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span class="ms-3 text-xs md:text-sm">Profile</span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div id="button-setting-security" onclick="handleSidebar('security')"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="ms-3 text-xs md:text-sm">Security</span>
                            </div>
                        </div>
                        @IsCompanyAdmin($companyId)
                        <div class="mb-2">
                            <div id="button-setting-company" onclick="handleSidebar('company');getCompany()"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M4.5 2.25a.75.75 0 0 0 0 1.5v16.5h-.75a.75.75 0 0 0 0 1.5h16.5a.75.75 0 0 0 0-1.5h-.75V3.75a.75.75 0 0 0 0-1.5h-15ZM9 6a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm-.75 3.75A.75.75 0 0 1 9 9h1.5a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM9 12a.75.75 0 0 0 0 1.5h1.5a.75.75 0 0 0 0-1.5H9Zm3.75-5.25A.75.75 0 0 1 13.5 6H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM13.5 9a.75.75 0 0 0 0 1.5H15A.75.75 0 0 0 15 9h-1.5Zm-.75 3.75a.75.75 0 0 1 .75-.75H15a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM9 19.5v-2.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-.75.75h-4.5A.75.75 0 0 1 9 19.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="ms-3 text-xs md:text-sm">Company</span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div id="button-setting-user" onclick="handleSidebar('user');getUser();getRole();"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                </svg>

                                <span class="ms-3 text-xs md:text-sm">User</span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div id="button-setting-role" onclick="handleSidebar('role');getRole()"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M11.828 2.25c-.916 0-1.699.663-1.85 1.567l-.091.549a.798.798 0 0 1-.517.608 7.45 7.45 0 0 0-.478.198.798.798 0 0 1-.796-.064l-.453-.324a1.875 1.875 0 0 0-2.416.2l-.243.243a1.875 1.875 0 0 0-.2 2.416l.324.453a.798.798 0 0 1 .064.796 7.448 7.448 0 0 0-.198.478.798.798 0 0 1-.608.517l-.55.092a1.875 1.875 0 0 0-1.566 1.849v.344c0 .916.663 1.699 1.567 1.85l.549.091c.281.047.508.25.608.517.06.162.127.321.198.478a.798.798 0 0 1-.064.796l-.324.453a1.875 1.875 0 0 0 .2 2.416l.243.243c.648.648 1.67.733 2.416.2l.453-.324a.798.798 0 0 1 .796-.064c.157.071.316.137.478.198.267.1.47.327.517.608l.092.55c.15.903.932 1.566 1.849 1.566h.344c.916 0 1.699-.663 1.85-1.567l.091-.549a.798.798 0 0 1 .517-.608 7.52 7.52 0 0 0 .478-.198.798.798 0 0 1 .796.064l.453.324a1.875 1.875 0 0 0 2.416-.2l.243-.243c.648-.648.733-1.67.2-2.416l-.324-.453a.798.798 0 0 1-.064-.796c.071-.157.137-.316.198-.478.1-.267.327-.47.608-.517l.55-.091a1.875 1.875 0 0 0 1.566-1.85v-.344c0-.916-.663-1.699-1.567-1.85l-.549-.091a.798.798 0 0 1-.608-.517 7.507 7.507 0 0 0-.198-.478.798.798 0 0 1 .064-.796l.324-.453a1.875 1.875 0 0 0-.2-2.416l-.243-.243a1.875 1.875 0 0 0-2.416-.2l-.453.324a.798.798 0 0 1-.796.064 7.462 7.462 0 0 0-.478-.198.798.798 0 0 1-.517-.608l-.091-.55a1.875 1.875 0 0 0-1.85-1.566h-.344ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span class="ms-3 text-xs md:text-sm">Role</span>
                            </div>
                        </div>
                        @endIsCompanyAdmin()
                    </div>
                </div>
            </div>
            <div class="col-span-4 lg:col-span-3 p-0 md:p-4 bg-gray-100 dark:bg-gray-600 rounded-xl">
                <div id="content-profile" class="content-user-setting p-4">
                    <div class="w-full  dark:bg-gray-600 rounded-xl">
                        <div class="flex flex-col gap-4">
                            <div class="p-4 bg-gray-200 dark:bg-gray-700 rounded-xl">
                                <div class="flex flex-row justify-between">
                                    <div class="flex flex-row items-center justify-start ps-2 md:ps-4 gap-8 ">
                                        <div class="h-full flex items-center hidden md:flex">
                                            <img src="{{ asset('image/user.png') }}" class="w-20 h-20 rounded-full">
                                        </div>
                                        <div class="h-full flex gap-4 items-center">
                                            <div>
                                                <h1 id="username" class="text-xs md:text-lg font-semibold text-gray-800 dark:text-white">
                                                    User Name
                                                </h1>
                                                <p id="company_display"
                                                    class="text-xs font-light text-gray-700 md:text-sm dark:text-white">
                                                    Company
                                                    Name</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4">
                                        <button onclick="showEditProfileModal()"
                                            class="px-4 flex items-center gap-2 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                            <span class="md:flex hidden">Edit</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                class="w-4 h-4">
                                                <path
                                                    d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                <path
                                                    d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full h-4/5 bg-gray-200 dark:bg-gray-700 rounded-xl">
                                <div class="grid grid-cols-2 p-4 gap-4">
                                    <div class="ps-2 pt-2 col-span-2 md:col-span-1">
                                        <h1 class="text-xs md:text-sm text-gray-800 dark:text-white font-semibold">First
                                            Name
                                        </h1>
                                        <h2 id="first_name_display" class="text-xs text-gray-700 md:text-sm pt-2 dark:text-white"></h2>
                                    </div>
                                    <div class="ps-2 pt-2 col-span-2 md:col-span-1">
                                        <h1 class="text-xs md:text-sm text-gray-800 dark:text-white font-semibold">Last Name
                                        </h1>
                                        <h2 id="last_name_display" class="text-xs text-gray-700 md:text-sm pt-2 dark:text-white"></h2>
                                    </div>
                                    <div class="ps-2 pt-2 col-span-2 md:col-span-1">
                                        <h1 class="text-xs md:text-sm text-gray-800 dark:text-white font-semibold">Phone
                                            Number
                                        </h1>
                                        <h2 id="phone_number_display" class="text-xs text-gray-700 md:text-sm pt-2 dark:text-white"></h2>
                                    </div>
                                    <div class="ps-2 pt-2 col-span-2 md:col-span-1 mb-4">
                                        <h1 class="text-xs md:text-sm text-gray-800 dark:text-white font-semibold">Gender
                                        </h1>
                                        <h2 id="gender_display" class="text-xs text-gray-700 md:text-sm pt-2 dark:text-white"></h2>
                                    </div>

                                    <div class="relative flex items-center justify-center col-span-2">
                                        <hr class="w-full border-gray-400 dark:border-gray-500">
                                        <span
                                            class="absolute px-3 text-xs text-gray-700 rounded-full bg-gray-100 dark:bg-gray-600 dark:text-white">Additional
                                            Info</span>
                                    </div>

                                    <div class="ps-2 pt-4 col-span-2 md:col-span-1">
                                        <h1 class="text-xs md:text-sm text-gray-800 dark:text-white font-semibold">Company
                                            Address</h1>
                                        <h2 id="address_display" class="text-xs md:text-sm pt-2 text-gray-700 dark:text-white">Not Set
                                        </h2>
                                    </div>
                                    <div class="ps-2 pt-4 col-span-2 md:col-span-1">
                                        <h1 class="text-xs md:text-sm text-gray-800 dark:text-white font-semibold">Company
                                            Type
                                        </h1>
                                        <h2 id="company_type_display" class="text-xs text-gray-700 md:text-sm pt-2 dark:text-white">Not
                                            Set</h2>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
                <div id="content-security" class="content-user-setting">
                    <div class=" bg-gray-100 dark:bg-gray-600 rounded-xl p-4">
                        <div class="bg-gray-200 dark:bg-gray-700 rounded-xl p-4">
                            <h1 class="text-xs md:text-sm font-semibold dark:text-white">Security</h1>
                            <p class="text-xs md:text-sm dark:text-white">This is the security setting page</p>
                        </div>
                        <div class="bg-gray-200 dark:bg-gray-700 rounded-xl p-4 mt-4">
                            <label for="password"
                                class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">New
                                Password</label>
                            <div class="flex pb-4 flex-col md:flex-row items-start md:items-center justify-start gap-2">
                                <input type="password" name="password" id="password" disabled
                                    class="mt-1 block min-w-64  p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <button onclick="authCheckPassword()" id="button-password-check"
                                    class="px-4 flex items-center gap-2 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                    Change
                                </button>
                                <div id="button-password-group" hidden>
                                    <button onclick="changePassword()"
                                        class="me-1 bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-800 text-white p-2 rounded-lg mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button onclick="cancelChangePassword()"
                                        class="bg-red-600 dark:bg-red-700 hover:bg-red-700 dark:hover:bg-red-800 text-white p-2 rounded-lg mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @IsCompanyAdmin($companyId)
                <div id="content-company" class="content-user-setting p-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-xl p-4">
                        <h1 class="text-xs text-gray-800 md:text-sm font-semibold dark:text-white">Company</h1>
                        <p class="text-xs md:text-sm text-gray-700 dark:text-white">This is the company setting page</p>
                    </div>
                    <div class="w-full mt-4 bg-gray-200 dark:bg-gray-700 rounded-xl ">
                        <div class="grid grid-cols-2 gap-4 p-4">
                            <div class="ps-2 pt-2 col-span-2">
                                <div class="flex flex-row justify-between">
                                    <div id="company-name-display"
                                        class="text-xs  md:text-sm dark:text-white text-gray-800 font-semibold">
                                        Company
                                        Name</div>
                                    <button onclick="showEditCompanyModal()"
                                        class="px-4 flex items-center gap-2 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                        <span class="md:flex hidden">Edit</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="w-4 h-4">
                                            <path
                                                d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                            <path
                                                d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="relative flex items-center justify-center col-span-2">
                                <hr class="w-full border-gray-400 dark:border-gray-500">
                            </div>
                            <div class="ps-2 pt-2 col-span-2 md:col-span-1">
                                <h1 class="text-xs md:text-sm text-gray-800 dark:text-white font-semibold">Company Email</h1>
                                <h2 id="company_email_display" class="text-xs text-gray-700 md:text-sm pt-2 dark:text-white">Not Set
                                </h2>
                            </div>
                            <div class="ps-2 pt-2 col-span-2 md:col-span-1">
                                <h1 class="text-xs md:text-sm dark:text-white text-gray-800 font-semibold">Owner</h1>
                                <h2 id="company_owner_display" class="text-xs md:text-sm pt-2 text-gray-700 dark:text-white">Not Set
                                </h2>
                            </div>
                            <div class="ps-2 pt-2 col-span-2 md:col-span-1">
                                <h1 class="text-xs md:text-sm dark:text-white text-gray-800 font-semibold">Allowed User</h1>
                                <h2 id="company_user_display" class="text-xs md:text-sm pt-2 text-gray-700 dark:text-white">Not Set</h2>
                            </div>
                            <div class="ps-2 pt-2 col-span-2 md:col-span-1">
                                <h1 class="text-xs md:text-sm dark:text-white text-gray-800 font-semibold">Address</h1>
                                <h2 id="company_address_display" class="text-xs md:text-sm pt-2 text-gray-700 dark:text-white">Not Set
                                </h2>
                            </div>
                            <div class="ps-2 pt-2 col-span-2 md:col-span-1">
                                <h1 class="text-xs md:text-sm dark:text-white font-semibold text-gray-800">Status</h1>
                                <h2 id="company_status_display" class="text-xs md:text-sm pt-2 text-gray-700 dark:text-white">Not Set
                                </h2>
                            </div>
                            <div class="ps-2 pt-2 col-span-2 md:col-span-1">
                                <h1 class="text-xs md:text-sm dark:text-white text-gray-800 font-semibold">Visibility</h1>
                                <h2 id="company_visibility_display" class="text-xs text-gray-700 md:text-sm pt-2 dark:text-white">Not
                                    Set</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="content-user" class="content-user-setting m-4">
                    <div class="bg-gray-200 dark:bg-gray-700 rounded-xl p-4">
                        <h1 class="text-xs md:text-sm font-semibold dark:text-white">User</h1>
                        <p class="text-xs md:text-sm dark:text-white">This is the user setting page</p>
                    </div>
                    <div class="rounded-lg overflow-x-auto mt-4">
                        <table
                            class="w-full min-w-[600px] text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">No</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Role</th>
                                    <th scope="col" class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-company-user">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="content-role" class="content-user-setting p-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-xl p-4 flex items-center justify-between">
                        <div>
                            <h1 class="text-xs  md:text-sm font-semibold dark:text-white">Role</h1>
                            <p class="text-xs md:text-sm dark:text-white">This is the role setting page</p>
                        </div>
                        <div>
                            <button onclick="showAddRoleModal()"
                                class="mx-4 bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white text-xs md:text-sm p-2 rounded-lg mt-1">
                                Add Role
                            </button>
                        </div>
                    </div>
                    <div class="rounded-lg overflow-x-auto mt-4">
                        <table
                            class="w-full min-w-[600px] text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">

                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbody-role-user">
                            </tbody>
                        </table>

                    </div>
                </div>
                @endIsCompanyAdmin()
            </div>

        </div>
    </div>


    <script>
        const active = ' bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white';
        const inactive =
            ' bg-gray-100 dark:bg-gray-700 hover:bg-white dark:hover:bg-gray-700 text-gray-900 dark:text-white';

        let profile = null;
        let company = null;
        let users = null;
        let roles = null;

        $(document).ready(function() {
            firstRender();
            getProfile();

            const otpInputs = $(".otp-input");
            otpInputs.on("input", function() {
                const input = $(this);
                const value = input.val().replace(/[^0-9]/g, "");
                input.val(value);

                if (value.length === 1) {
                    input.next(".otp-input").focus();
                }
            });

            otpInputs.on("keydown", function(e) {
                if (e.key === "Backspace" && !$(this).val()) {
                    $(this).prev(".otp-input").focus();
                }
            });

        })

        function firstRender() {
            $(".side-button").addClass(inactive).removeClass(active);
            $(".content-user-setting").hide();
            $("#button-setting-profile").removeClass(inactive).addClass(active);
            $("#content-profile").show();
        }

        function handleSidebar(content) {
            $(".side-button").removeClass(active).addClass(inactive);
            $("#button-setting-" + content).removeClass(inactive).addClass(active);
            $(".content-user-setting").hide();
            $("#content-" + content).show();
        }

        function getProfile() {
            $.ajax({
                url: "{{ route('getProfileDetails') }}",
                type: "GET",
                success: function(response) {
                    profile = response.data;
                    setProfileInformation(profile);
                }
            })
        }

        function setProfileInformation(profile) {
            $("#first_name_display").text(profile.first_name);
            $("#last_name_display").text(profile.last_name);
            $("#phone_number_display").text(profile.phone);
            $("#gender_display").text(profile.gender);
            $("#address_display").text(profile.company ? profile.company.address : "Not Set");
            $("#company_type_display").text(profile.company ? profile.company.type : "Not Set");
            $("#username").text(profile.email);
            $("#company_display").text(profile.company ? profile.company.name : "");
        }

        function showEditProfileModal() {
            showModal("edit-profile-modal");
            $("#first_name").val(profile.first_name);
            $("#last_name").val(profile.last_name);
            $("#phone_number").val(profile.phone);
            $("#gender").val(profile.gender);
            $("#email").val(profile.email);
            $("#error_message_field_profile").hide();
        }


        function submitEditModal() {
            let data = {
                id: profile.id,
                first_name: $("#first_name").val(),
                last_name: $("#last_name").val(),
                phone: $("#phone_number").val(),
                gender: $("#gender").val(),
                email: $("#email").val(),
                _token: "{{ csrf_token() }}"
            }
            $.ajax({
                url: "{{ route('updateProfile') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    if (response.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonColor: '#22c55e',
                            confirmButtonText: 'Ok'
                        })
                        getProfile();
                        hideModal("edit-profile-modal");
                    }
                },
                error: function(xhr) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    var errors = errorMessage.message;
                    $('#error_message_field_profile').show();
                    $('#error_message_profile').empty();
                    $('#error_message_profile').append(`<li>${errors}</li>`);
                }
            })
        }

        function authCheckPassword() {
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let userId = profile.id;
            $.ajax({
                url: "{{ route('sendOtp') }}",
                type: "POST",
                data: {
                    id: userId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        title: "<strong>Check your mailbox!</strong>",
                        icon: "info",
                        text: "We have sent an OTP to your email address. Please check your email and enter the OTP to continue.",
                        closeOnClickOutside: false,
                        confirmButtonColor: '#40c3ed',
                        confirmButtonText: 'Ok'
                    });
                    showStaticModal("otp-modal");
                },
                error: function(xhr) {}
            })
        }

        function verifyOTP() {
            let data = {
                otp: $("#otp-1").val() + $("#otp-2").val() + $("#otp-3").val() + $("#otp-4").val() + $("#otp-5").val() +
                    $("#otp-6").val(),
                _token: "{{ csrf_token() }}"
            }
            $.ajax({
                url: "{{ route('verifyOtp') }}",
                type: "POST",
                data: data,
                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'Ok'
                    })
                    $("#password").prop("disabled", false);
                    $("#button-password-group").show();
                    $("#button-password-check").hide();
                    hideModal("otp-modal");

                },
                error: function(xhr) {
                    var error = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Close'
                    });
                }
            })
        }

        function resendOTP() {
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let userId = profile.id;
            $.ajax({
                url: "{{ route('sendOtp') }}",
                type: "POST",
                data: {
                    id: userId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'Ok'
                    })
                },
                error: function(xhr) {}
            })
        }

        function changePassword() {
            let data = {
                id: profile.id,
                password: $("#password").val(),
                _token: "{{ csrf_token() }}"
            }
            $.ajax({
                url: "{{ route('changePassword') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'Ok'
                    })
                    cancelChangePassword();
                },
                error: function(xhr) {
                    var error = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Close'
                    });
                }
            })
        }

        function cancelChangePassword() {
            $("#password").prop("disabled", true);
            $("#button-password-group").hide();
            $("#button-password-check").show();
            $("#password").val("");
        }

        function getCompany() {
            $.ajax({
                url: "{{ route('getCompanyDetails') }}",
                type: "GET",
                success: function(response) {
                    company = response.data;
                    setCompanyInformation(company);
                }
            })
        }

        function setCompanyInformation(company) {
            $("#company-name-display").text(company.name);
            $("#company_email_display").text(company.email);
            $("#company_owner_display").text(company.user.email);
            $("#company_user_display").text(company.max_account);
            $("#company_address_display").text(company.address);
            $("#company_status_display").text(company.status.name);
            $("#company_visibility_display").text(company.visibility.name);
        }

        function showEditCompanyModal() {
            showModal("edit-company-modal");
            $("#company_id").val(company.id);
            $("#company_name").val(company.name);
            $("#company_email").val(company.email);
            $("#company_address").val(company.address);
            $("#company_max_account").val(company.max_account);
            $("#company_status").val(company.status_id);
            $("#company_owner").val(company.user.email);
            $("#company_visibility").val(company.visibility_id);
            $("#error_message_field_update_company").hide();
        }

        function submitEditCompanyModal() {
            let data = {
                id: $("#company_id").val(),
                name: $("#company_name").val(),
                email: $("#company_email").val(),
                address: $("#company_address").val(),
                max_account: $("#company_max_account").val(),
                status_id: $("#company_status").val(),
                visibility_id: $("#company_visibility").val(),
                _token: "{{ csrf_token() }}"
            }
            $.ajax({
                url: "{{ route('updateCompany') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    if (response.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonColor: '#22c55e',
                            confirmButtonText: 'Ok'
                        })
                        getCompany();
                        hideModal("edit-company-modal");
                    }
                },
                error: function(xhr) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    var errors = errorMessage.message;

                    $('#error_message_field_update_company').show();
                    $('#error_message_update_company').empty();
                    $('#error_message_update_company').append(`<li>${errors}</li>`);
                }
            })
        }

        function getUser() {
            $.ajax({
                url: "{{ route('getCompanyUsers') }}",
                type: "GET",
                success: function(response) {
                    users = response.data;
                    console.log(users);
                    let html = "";
                    $("#tbody-company-user").empty();
                    users.forEach((user, index) => {
                        html = `
                            <tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="px-6 py-4">
                                    ${index + 1}
                                </td>
                                <td class="px-6 py-4">
                                    ${user.first_name} ${user.last_name}
                                </td>
                                <td class="px-6 py-4">
                                    ${user.email}
                                </td>
                                <td class="px-6 py-4">
                                    ${user.role ? user.role.name : "Not Set"}
                                </td>
                                <td class="px-6 py-4">
                                    <button onclick="showEditUserModal(${user.id})"
                                        class="px-4 flex items-center gap-2 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                        <span class="">Edit</span>
                                    </button>
                                </td>
                            </tr>
                        `;
                        $("#tbody-company-user").append(html);
                    });
                }
            })
        }

        function showEditUserModal(id) {

            let tempUser = users.find(user => user.id == id);
            $("#user_role").empty();
            $("#user_role").append(`<option disabled value="">Select User Role</option>`);
            roles.forEach((role) => {
                $("#user_role").append(`<option value="${role.id}">${role.name}</option>`);
            })
            $("#user_role").val(tempUser.role_id);
            $("#user_first_name").val(tempUser.first_name);
            $("#user_last_name").val(tempUser.last_name);
            $("#phone_user").val(tempUser.phone)
            $("#email_user").val(tempUser.email);
            $("#user_id").val(tempUser.id);
            $("#error_message_field_update_user").hide();
            showModal("update-user-modal");
        }

        function updateUser() {
            let data = {
                id: $("#user_id").val(),
                first_name: $("#user_first_name").val(),
                last_name: $("#user_last_name").val(),
                phone: $("#phone_user").val(),
                email: $("#email_user").val(),
                role_id: $("#user_role").val(),
                _token: "{{ csrf_token() }}"
            }
            $.ajax({
                url: "{{ route('updateUserCompany') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    if (response.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonColor: '#22c55e',
                            confirmButtonText: 'Ok'
                        })
                        getUser();
                        hideModal("update-user-modal");
                    }
                },
                error: function(xhr) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    var errors = errorMessage.message;
                    $('#error_message_field_update_user').show();
                    $('#error_message_update_user').empty();
                    $('#error_message_update_user').append(`<li>${errors}</li>`);

                }
            })
        }


        function getRole() {
            $.ajax({
                url: "{{ route('getRoles') }}",
                type: "GET",
                success: function(response) {
                    roles = response.data;
                    let html = "";
                    $("#tbody-role-user").empty();
                    roles.forEach((role, index) => {
                        html = `
                            <tr class="text-xs md:text-sm font-light text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="px-6 py-4">
                                    ${index + 1}
                                </td>
                                <td class="px-6 py-4">
                                    ${role.name}
                                </td>
                                <td class="px-6 py-4">
                                </td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button onclick="showEditRoleModal(${role.id})"
                                        class="px-4 flex items-center gap-2 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                        <span class="">Edit</span>
                                    </button>
                                    <button onclick="deleteRole(${role.id})"
                                        class="px-4 flex items-center gap-2 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">
                                        <span class="">Delete</span>
                                    </button>
                                </td>
                            </tr>
                        `;
                        $("#tbody-role-user").append(html);
                    });
                }
            })
        }

        async function showEditRoleModal(id) {
            await $.ajax({
                url: "{{ route('getRoleDetails') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    let roleAttribute = response.data;
                    let role = response.role;
                    setRoleAccess(roleAttribute, role);
                }
            })
            $("#button-for-submit-role").text("Update");
            $("#button-for-submit-role").removeAttr('onclick').attr('onclick', 'updateRole()');
            $("#title-create-role-modal").text("Update Role");
            showModal('create-role-modal');
        }

        function showAddRoleModal() {
            $("#button-for-submit-role").text("Add");
            $("#title-create-role-modal").text("Add Role");
            $("#button-for-submit-role").removeAttr('onclick').attr('onclick', 'addRole()');
            $(".access-role-checkbox input[type='checkbox']").prop("checked", false);
            $("#role_id").val("");
            $("#role_name").val("");
            $("#is_admin_role").prop("checked", false);
            showModal('create-role-modal');
        }

        function setRoleAccess(roleAttribute, role) {
            $(".access-role-checkbox input[type='checkbox']").prop("checked", false);
            role.company_admin == 1 ? $("#is_admin_role").prop("checked", true) : $("#is_admin_role").prop("checked",
                false);
            $("#role_id").val(role.id);
            $("#role_name").val(role.name);
            roleAttribute.forEach((attribute) => {
                $(`#access-${attribute.module_abilities_id}`).prop("checked", true);
            })
        }

        function addRole() {
            let data = {
                name: $("#role_name").val(),
                is_admin: $("#is_admin_role").is(":checked") ? 1 : 0,
                access: [],
                _token: "{{ csrf_token() }}"
            }
            $(".access-role-checkbox input[type='checkbox']").each(function() {
                if ($(this).is(":checked")) {
                    data.access.push($(this).data('value'));
                }
            })
            $.ajax({
                url: "{{ route('createRole') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    if (response.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonColor: '#22c55e',
                            confirmButtonText: 'Ok'
                        })
                        getRole();
                        hideModal("create-role-modal");
                    }
                },
                error: function(xhr) {
                    var error = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Close'
                    });
                }
            })
        }

        function updateRole() {
            let data = {
                id: $("#role_id").val(),
                name: $("#role_name").val(),
                is_admin: $("#is_admin_role").is(":checked") ? 1 : 0,
                access: [],
                _token: "{{ csrf_token() }}"
            }
            $(".access-role-checkbox input[type='checkbox']").each(function() {
                if ($(this).is(":checked")) {
                    data.access.push($(this).data('value'));
                }
            })
            $.ajax({
                url: "{{ route('updateRole') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    if (response.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonColor: '#22c55e',
                            confirmButtonText: 'Ok'
                        })
                        getRole();
                        hideModal("create-role-modal");
                    }
                },
                error: function(xhr) {
                    var error = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Close'
                    });
                }
            })
        }


        function deleteRole(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteRole') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    confirmButtonColor: '#22c55e',
                                    confirmButtonText: 'Ok'
                                })
                                getRole();
                            }
                        },
                        error: function(xhr) {
                            var error = JSON.parse(xhr.responseText);
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: error.message,
                                confirmButtonColor: '#ef4444',
                                confirmButtonText: 'Close'
                            });
                        }
                    })
                }
            })
        }
    </script>
@endsection
