<div id="import-site-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full h-full md:inset-0 bg-black bg-opacity-50">
    <div class="p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="title-add-landing-page-modal">
                    Import Site
                </h3>
                <button type="button" onclick="hideModal('import-site-modal')"
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
                <div class="grid grid-cols-2 gap-0 md:gap-8">
                    <div class="col-span-2 lg:col-span-2" id="sending-profile-form">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label for="url_website"
                                    class="block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-200">URL
                                    </label>
                                <input type="text" id="url_website" name="url_website"
                                    placeholder="https://example.com"
                                    class="mt-1 bg-gray-100 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs md:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2">
                                <div id="error-http-header" hidden>
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-1 rounded-lg shadow-md"
                                        role="alert">
                                        <strong class="font-bold">Whoops!</strong>
                                        <span class="block sm:inline">Please fill URL field</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div
                class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 gap-2">
                <button data-modal-hide="static-modal" type="button"
                    onclick="hideModal('import-site-modal')"
                    class="py-2.5 px-5 text-xs md:text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                <button id="add-profile-button" data-modal-hide="static-modal" type="button"
                    onclick="fetchWebsiteUrl()"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs md:text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                </button>
            </div>
        </div>
    </div>
</div>
