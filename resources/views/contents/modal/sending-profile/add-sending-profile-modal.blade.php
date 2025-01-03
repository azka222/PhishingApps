<div id="add-sending-profile-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)]">
    <div class="relative p-4 w-full max-w-7xl">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="title-add-sending-profile-modal">
                    Create Sending Profile
                </h3>
                <button type="button" onclick="hideModal('add-group-modal')"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                    <div class="col-span-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="profile_name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Profile
                                    Name</label>
                                <input type="text" id="profile_name" name="profile_name"
                                    placeholder="Enter profile name"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-1">
                                <label for="interface_type"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Interface
                                    Type</label>
                                <input type="text" id="interface_type" name="interface_type"
                                    placeholder="should be smtp" value="smtp" disabled
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-1">
                                <label for="email_smtp"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">SMTP
                                    Email</label>
                                <input type="text" id="email_smtp" name="email_smtp"
                                    placeholder="Enter email"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-1">
                                <label for="first_name_smtp"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">SMTP First
                                    Name</label>
                                <input type="text" id="first_name_smtp" name="first_name_smtp"
                                    placeholder="Enter first name"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-1">
                                <label for="last_name_smtp"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">SMTP Last
                                    Name</label>
                                <input type="text" id="last_name_smtp" name="last_name_smtp"
                                    placeholder="Enter last name"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-1">
                                <label for="smtp_host"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">SMTP Host</label>
                                <input type="text" id="smtp_host" name="smtp_host" placeholder="smtp.example.com:587"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-1">
                                <label for="ignore_certificate"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Ignore
                                    Certificate Error</label>
                                <select id="ignore_certificate" name="ignore_certificate"
                                    class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label for="username_profile"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Username</label>
                                <input type="text" id="username_profile" name="username_profile"
                                    placeholder="Enter username"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-1">
                                <label for="password_username"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                                <input type="password" id="password_username" name="password_username"
                                    placeholder="Enter password"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>



                            <div class="col-span-2">
                                <div id="error_message_field" hidden>
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md relative"
                                        role="alert">
                                        <strong class="font-bold">Whoops!</strong>
                                        <span class="block sm:inline">There were some problems with your input.</span>
                                        <ul id="error_message"class="mt-3 list-disc list-inside text-sm">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="w-full">
                            <label for="group_member"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Group Member</label>
                            <select id="group_member" name="group_member" onchange="addUserToGroup(this.value)"
                                class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </select>
                        </div>
                        <div class="mt-4 flex flex-row justify-between items-center">
                            <span class=" text-sm font-medium text-gray-900 dark:text-gray-300">Import target
                                from selected department ?</span>
                            <button type="button" onclick="importTargetFromDepartment()"
                                id="import_target_from_department"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Import
                            </button>
                        </div>
                        <div class="mt-4 max-h-96 overflow-y-auto" id="group_member_list">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div
                class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 gap-2">
                <button data-modal-hide="static-modal" type="button" onclick="hideModal('add-group-modal')"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                <button id="button-for-group" data-modal-hide="static-modal" type="button" onclick="createGroup()"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                </button>
            </div>
        </div>
    </div>
</div>
