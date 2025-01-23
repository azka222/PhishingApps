<div id="create-role-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="title-create-role-modal">
                    Create Role
                </h3>
                <button type="button" onclick="hideModal('create-role-modal')"
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
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <input type="hidden" id="role_id" name="role_id">
                        <label for="role_name"
                            class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">Role
                            Name</label>
                        <input type="text" id="role_name" name="role_name" placeholder="Enter role name"
                            class="mt-1 block w-full bg-gray-100 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                    </div>
                    <div class="col-span-2">
                        <div class="flex items-center justify-between">
                            <span class=" text-sm font-medium text-gray-900 dark:text-gray-300">Is Admin Role?</span>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="is_admin_role" value="" class="sr-only peer">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>
                            </label>
                            
                        </div>
                    </div>


                    @foreach ($modules as $module)
                        <div class="col-span-2 lg:col-span-1 bg-gray-100 dark:bg-gray-600 rounded-lg p-2 my-2">
                            <div class="flex items-center justify-center">
                                <label for=""
                                    class="mb-2 text-xs md:text-sm font-bold text-gray-700 dark:text-gray-200">{{ $module['module_name'] }}</label>
                            </div>
                            <div
                                class="grid grid-cols-2 md:grid-cols-4 p-2 items-center dark:bg-gray-800 rounded-lg bg-white gap-2 md:gap-8">
                                @foreach ($module['abilities'] as $item)
                                    <div class="col-span-1 flex items-center mb-4 access-role-checkbox">
                                        <input id="access-{{ $item['id_module_ability'] }}" type="checkbox"
                                            data-value="{{ $item['id_module_ability'] }}"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-checkbox"
                                            class="ms-2 text-sm font-light text-gray-900 dark:text-gray-300">{{ $item['name'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

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
            <!-- Modal footer -->
            <div
                class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 gap-2">
                <button data-modal-hide="static-modal" type="button" onclick="hideModal('create-role-modal')"
                    class="py-2.5 px-5 ms-3 text-xs md:text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                <button id="button-for-submit-role" data-modal-hide="static-modal" type="button" onclick="createRole()"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs md:text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                </button>
            </div>
        </div>
    </div>
</div>
