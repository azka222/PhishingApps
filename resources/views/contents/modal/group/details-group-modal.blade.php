<div id="details-group-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)]">
    <div class="relative p-4 w-full max-w-7xl">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="title-details-group-modal">
                    Details Group
                </h3>
                <button type="button" onclick="hideModal('details-group-modal')"
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
                    <div class="col-span-2">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="group_name_details"
                                    class="block text-md font-medium text-gray-700 dark:text-gray-200">Group
                                    Name</label>
                                <h3 id="group_name_details" class="mt-1 text-gray-900 text-sm dark:text-white">Group
                                    Name Value
                                </h3>
                            </div>
                            <div>
                                <label for="group_status_details"
                                    class="block text-md font-medium text-gray-700 dark:text-gray-200">Group
                                    Status</label>
                                <h3 id="group_status_details" class="mt-1 text-gray-900 text-sm dark:text-white">Group
                                    Status
                                    Value</h3>
                            </div>
                            <div>
                                <label for="group_created_at_details"
                                    class="block text-md font-medium text-gray-700 dark:text-gray-200">Created
                                    At</label>
                                <h3 id="group_created_at_details" class="mt-1 text-gray-900 text-sm dark:text-white">
                                    Created At
                                    Value</h3>
                            </div>
                            <div>
                                <label for="group_updated_at_details"
                                    class="block text-md font-medium text-gray-700 dark:text-gray-200">Updated
                                    At</label>
                                <h3 id="group_updated_at_details" class="mt-1 text-gray-900 text-sm dark:text-white">
                                    Updated At
                                    Value</h3>
                            </div>
                            <div>
                                <label for="group_department_details"
                                    class="block text-md font-medium text-gray-700 dark:text-gray-200">Group
                                    Department</label>
                                <h3 id="group_department_details" class="mt-1 text-gray-900 text-sm dark:text-white">
                                    Updated At
                                    Value</h3>
                            </div>
                            <div>
                                <label for="group_member_count_details"
                                    class="block text-md font-medium text-gray-700 dark:text-gray-200">Total
                                    Members</label>
                                <h3 id="group_member_count_details" class="mt-1 text-gray-900 text-sm dark:text-white">
                                    Updated At
                                    Value</h3>
                            </div>
                            <div class="col-span-2">
                                <label for="group_description_details"
                                    class="block text-md font-medium text-gray-700 dark:text-gray-200">Group
                                    Description</label>
                                <h3 id="group_description_details" class="mt-1 text-gray-900 text-sm dark:text-white">
                                    Group
                                    Description Value</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="overflow-y-auto max-h-72">
                            <table class="p-4 min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                                <thead class="bg-gray-300 dark:bg-gray-800">
                                    <tr
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                        <th scope="col" class="p-4">Name</th>
                                        <th scope="col" class="p-4">Position</th>
                                        <th scope="col" class="p-4">Department</th>
                                        <th scope="col" class="p-4">Email</th>
                                    </tr>
                                </thead>
                                <tbody id="list-targets-groups-tbody"
                                    class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                                </tbody>
                            </table>
                        </div>  
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div
                class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 gap-2">
                <button data-modal-hide="static-modal" type="button" onclick="hideModal('details-group-modal')"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
            </div>
        </div>
    </div>
</div>
