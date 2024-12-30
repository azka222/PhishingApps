<div id="add-email-templates-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)]">
    <div class="relative p-4 w-full max-w-7xl">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="title-add-email-templates-modal">
                    Create Email Templates
                </h3>
                <button type="button" onclick="hideModal('add-email-templates-modal')"
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
                                <label for="template_name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Template
                                    Name</label>
                                <input type="text" id="template_name" name="template_name"
                                    placeholder="Enter template name"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-2">
                                <label for="email_subject"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email
                                    Subject</label>
                                <input type="email" id="email_subject" name="email_subject"
                                    placeholder="Enter email subject"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-1">
                                <label for="sender_name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sender
                                    Name</label>
                                <input type="text" id="sender_name" name="sender_name"
                                    placeholder="Enter sender name"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>
                            <div class="col-span-1">
                                <label for="sender_email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sender
                                    Email</label>
                                <input type="text" id="sender_email" name="sender_email"
                                    placeholder="Enter sender email"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-600 dark:border-gray-700 dark:text-gray-300">
                            </div>


                            <div class="col-span-1">
                                <label for="email_status"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                                <select id="email_status" name="email_status" disabled
                                    class="mt-1 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option selected value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-span-1">
                                <label for="email_attachment"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">Attachment
                                </label>
                                <input
                                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 col-span-5 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="email_attachment" type="file" name="email_attachment">
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
                            <label for="email_body"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email
                                Body</label>
                            <div class="flex items-center justify-start gap-4 mt-2">
                                <div class="flex items-center">
                                    <input checked id="radio-html" type="radio" value="html" name="default-radio"
                                        onchange="showTextArea('html')"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="radio-html"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">HTML</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="radio-text" type="radio" value="plain-text" name="default-radio"
                                        onchange="showTextArea('text')"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="radio-text"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Plain
                                        Text</label>
                                </div>
                            </div>
                            <div class="mt-7" id="html-body">
                                <label for="email_html"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">HTML Format
                                </label>
                                <textarea id="email_html" rows="9"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Enter html format for email"></textarea>
                            </div>
                            <div class="mt-7" id="text-body" hidden>
                                <label for="email_text"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plain Text
                                </label>
                                <textarea id="email_text" rows="9"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Enter email plain text"></textarea>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div
                class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 gap-2">
                <button data-modal-hide="static-modal" type="button"
                    onclick="hideModal('add-email-templates-modal')"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                <button id="button-for-email-template" data-modal-hide="static-modal" type="button"
                    onclick="createEmailTemplates()"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                </button>
            </div>
        </div>
    </div>
</div>
