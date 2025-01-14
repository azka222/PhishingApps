<div id="add-sending-profile-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full md:inset-0 bg-black bg-opacity-50">
    <div class="p-4 w-full max-w-7xl mt-32">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="title-add-sending-profile-modal">
                    Create Sending Profile
                </h3>
                <button type="button" onclick="hideModal('add-sending-profile-modal')"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-xs md:text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="static-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div class="grid grid-cols-2 gap-8">
                    <div class="col-span-2 lg:col-span-1" id="sending-profile-form">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="profile_name"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Profile
                                    Name</label>
                                <input type="text" id="profile_name" name="profile_name"
                                    placeholder="Enter profile name"
                                    class="mt-1 bg-gray-100 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2">
                                <label for="email_smtp"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">SMTP
                                    Email</label>
                                <input type="text" id="email_smtp" name="email_smtp" placeholder="Enter email"
                                    class="mt-1 bg-gray-100 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="interface_type"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Interface
                                    Type</label>
                                <input type="text" id="interface_type" name="interface_type"
                                    placeholder="should be smtp" value="smtp" disabled
                                    class="mt-1 bg-gray-100 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2 lg:col-span-1 for-edit-profile">
                                <label for="status"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                                <select id="profile_status" name="status"
                                    class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                            <div class="col-span-2 lg:col-span-1">
                                <label for="smtp_host"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">SMTP
                                    Host</label>
                                <input type="text" id="smtp_host" name="smtp_host" placeholder="smtp.example.com:587"
                                    class="mt-1 bg-gray-100 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="ignore_certificate"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Ignore
                                    Certificate Error</label>
                                <select id="ignore_certificate" name="ignore_certificate"
                                    class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="username_profile"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Username</label>
                                <input type="text" id="username_profile" name="username_profile"
                                    placeholder="Enter username"
                                    class="bg-gray-100 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="password_profile"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                                <input type="password" id="password_profile" name="password_profile"
                                    placeholder="Enter password"
                                    class="mt-1 bg-gray-100 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>



                            <div class="col-span-2">
                                <div id="error_message_field" hidden>
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md relative"
                                        role="alert">
                                        <strong class="font-bold">Whoops!</strong>
                                        <span class="block sm:inline">There were some problems with your input.</span>
                                        <ul id="error_message"class="mt-3 list-disc list-inside text-xs md:text-sm">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 lg:col-span-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <div class="flex flex-row items-end justify-between">
                                    <div class="w-5/6 flex flex-row gap-4">
                                        <div class="flex flex-col w-1/2">
                                            <label for="header_email"
                                                class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Email
                                                Headers</label>
                                            <input type="text" id="header_email" name="header_email"
                                                placeholder="X-Custom-Header" disabled
                                                class="bg-gray-100 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                                        </div>
                                        <div class="flex flex-col w-1/2">
                                            <label for="header_value"
                                                class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Value</label>
                                            <input type="text" id="header_value" name="header_value"
                                                placeholder="Enter header value"
                                                class="bg-gray-100 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                                        </div>
                                    </div>
                                    <div class="w-1/6 flex justify-end">
                                        <button id="button-for-header" type="button" onclick="addHttpHeader()"
                                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs md:text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <div id="error-http-header" hidden>
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-1 rounded-lg shadow-md"
                                        role="alert">
                                        <strong class="font-bold">Whoops!</strong>
                                        <span class="block sm:inline">Please fill both field</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 max-h-32 md:max-h-96 overflow-y-auto" id="http-header-list">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div
                class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 gap-2">
                <button id="button-test-mail" data-modal-hide="static-modal" type="button" onclick="showTestModal()"
                    class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-xs md:text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">Test
                </button>
                <button data-modal-hide="static-modal" type="button"
                    onclick="hideModal('add-sending-profile-modal')"
                    class="py-2.5 px-5 text-xs md:text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                <button id="button-for-profile" data-modal-hide="static-modal" type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs md:text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                </button>
            </div>
        </div>
    </div>
</div>
