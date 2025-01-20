<div id="add-campaign-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-7xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="title-add-campaign-modal">
                    Create Campaign
                </h3>
                <button type="button" onclick="hideModal('add-campaign-modal')"
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
                    <div class="col-span-2 md:col-span-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="campaign_name"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Campaign
                                    Name</label>
                                <input type="text" id="campaign_name" name="campaign_name"
                                    placeholder="Enter campaign name"
                                    class="mt-1 block bg-gray-100 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="campaign_template"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Email
                                    Template</label>
                                <select id="campaign_template" name="campaign_template"
                                    class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select Email Template</option>
                                </select>
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="campaign_page"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Landing
                                    Page</label>
                                <select id="campaign_page" name="campaign_page"
                                    class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Select Landing Page</option>
                                </select>
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="campaign_launch_date"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Campaign Launch
                                    Date</label>
                                <input type="datetime-local" id="campaign_launch_date" name="campaign_launch_date"
                                    class="bg-gray-100 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="campaign_end_date"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Campaign End
                                    Date</label>
                                <input type="datetime-local" id="campaign_end_date" name="campaign_end_date"
                                    class="bg-gray-100 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="campaign_status"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                                <select id="campaign_status" name="campaign_status" disabled
                                    class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-span-2 lg:col-span-1">
                                <label for="campaign_url"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">URL
                                </label>
                                <input type="text" id="campaign_url" name="campaign_url" placeholder="Enter url"
                                    class="bg-gray-100 mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2">
                                <div class="flex flex-row items-end justify-between gap-4">
                                    <div class="w-5/6 flex flex-row gap-4">
                                        <div class="flex flex-col w-full">
                                            <label for="campaign_profile"
                                                class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Sending
                                                Profile</label>
                                            <select id="campaign_profile" name="campaign_profile"
                                                class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="">Select Sending Profile</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-1/6 flex justify-end">
                                        <button id="button-for-test" type="button" onclick="showTestConnectionModal()"
                                            class=" text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-xs md:text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">Test
                                        </button>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <div id="error_message_field" hidden>
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md relative"
                                        role="alert">
                                        <strong class="font-bold">Whoops!</strong>
                                        <span class="block sm:inline">There were some problems with your
                                            input.</span>
                                        <ul id="error_message"class="mt-3 list-disc list-inside text-xs md:text-sm">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <div class="w-full">
                            <label for="group_campaign"
                                class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Group Member</label>
                            <select id="group_campaign" name="group_campaign"
                                onchange="addGroupToCampaign(this.value)"
                                class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </select>
                        </div>
                        <div class="mt-4 max-h-96 overflow-y-auto" id="group-list">

                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div
                    class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 gap-2">
                    <button data-modal-hide="static-modal" type="button" onclick="hideModal('add-campaign-modal')"
                        class="py-2.5 px-5 ms-3 text-xs md:text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                    <button id="button-for-group" data-modal-hide="static-modal" type="button"
                        onclick="createCampaign()"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs md:text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
