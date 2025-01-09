<!-- Main modal -->
<div id="import-target-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Import Target
                </h3>
                <button type="button" onclick="hideModal('import-target-modal')"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-xs md:text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5">
                <div class="mb-4">
                    <label for="targetFile" class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Import
                        Target<span class="text-red-700 dark:text-red-500">*</span></label>
                    <div class="flex flex-row gap-2">
                        <input
                            class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 col-span-5 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            id="targetFile" type="file" name="targetFile" accept=".csv">
                        <input type="text" name="separator" id="separator" value=","
                            maxlength="1"
                            class="bg-gray-50 col-span-1 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-16 p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Company Separator" required="">
                    </div>
                    <p class="text-xs mt-2 text-red-700 dark:text-red-500">* Only CSV files can be uploaded.</p>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex flex-col gap-1 text-xs">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Download
                            template target</a>
                    </div>
                    <button type="button" onclick="previewImportTarget()"
                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Preview
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
