<div id="show-all-employee-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-6xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                     Show All Human Risks
                </h3>
                <button type="button" onclick="hideModal('show-all-employee-modal')"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                </div>
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                    aria-labelledby="profile-tab">
                    <div class="relative overflow-x-auto max-h-64 overflow-y-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                       Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Phishing Score
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Course Score
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Risk to Company
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="all-human-risk-body">
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="flex justify-end items-center mt-5 gap-2">
                        <button type="button"
                            onclick="hideModal('show-all-employee-modal');showModal('import-target-modal')"
                            class="py-2.5 px-5 ms-3 text-xs md:text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>