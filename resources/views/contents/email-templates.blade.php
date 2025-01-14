@extends('layouts.master')
@section('title', 'Email Template')
@section('content')
    @include('contents.modal.email-templates.add-email-templates-modal')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Email Templates</h1>
                @CanCreateEmailTemplate()
                <div>
                    <button onclick="showAddEmailTemplatesModal()"
                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 md:hidden">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="hidden md:inline">Create Campaign</span>
                    </button>
                </div>
                @endCanCreateEmailTemplate()
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="status"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status" onchange="getEmailTemplates()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                @IsAdmin()
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="companyCheckAdmin"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                        <select id="companyCheckAdmin" name="companyCheckAdmin" onchange="getEmailTemplates()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endIsAdmin()
                <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                    <div class="flex md:flex-row flex-col items-start md:items-center mb-4 md:mb-0">
                        <label for="show" class="mr-2 text-xs md:text-sm font-medium mb-2 md:mb-0">Show</label>
                        <select id="show" name="show" onchange="getEmailTemplates()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getEmailTemplates()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class="min-w-32 overflow-x-auto md:min-w-full">
                    <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                <th scope="col" class="p-4">Template Name</th>
                                <th scope="col" class="p-4">Sender</th>
                                <th scope="col" class="p-4">Email</th>
                                <th scope="col" class="p-4">Subject</th>
                                @CanModifyEmailTemplate()
                                <th scope="col" class="p-4">Action</th>
                                @endCanModifyEmailTemplate()
                            </tr>
                        </thead>
                        <tbody id="list-email-templates-tbody"
                            class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                        </tbody>
                    </table>
                </div>
                <nav class="flex items-center flex-column flex-col md:flex-row justify-between p-4"
                    aria-label="Table navigation">
                    <span
                        class="mb-4 md:mb-0 text-xs md:text-sm font-normal text-gray-500 dark:text-gray-400 block w-full md:inline md:w-auto">Showing
                        <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">0</span> -
                            <span id="numberLastItem">0</span></span> of
                        <span id="totalTemplatesCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                    </span>
                    <ul id="page-button-email-templates-company"
                        class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                    </ul>
                </nav>
            </div>
        </div>


        <script>
            let emailTemplates = [];
            $(document).ready(function() {
                getEmailTemplates();
            });

            function showAddEmailTemplatesModal() {
                showModal('add-email-templates-modal');
                $("#template_name").val('');
                $("#email_subject").val('');
                $("#email_text").val('');
                $("#email_status").val(1);
                $("#email_attachment").val('');
                $("#error_message_field").hide();
                $("#email_status").prop('disabled', true);
                $("#sender_name").val('');
                $("#sender_email").val('');
                $("#email_html").val('');
                $("#title-add-email-templates-modal").text('Add Email Templates');
                $("#button-for-email-template").text('Create');
                $("#button-for-email-template").removeAttr('onclick').attr('onclick',
                    'createEmailTemplates()');
                $("#admin_company_input_div").show();
            }

            function createEmailTemplates() {
                let template_name = $("#template_name").val();
                let email_subject = $("#email_subject").val();
                let email_body = $("#email_body").val() == 'text' ? $("#email_text").val() : $("#email_html").val();
                let status = $("#email_status").val();
                let sender_name = $("#sender_name").val();
                let body_type = $("#email_body").val();
                let sender_email = $("#sender_email").val();
                let email_attachment = $("#email_attachment")[0].files[0];
                let company = $("#admin_company_input").val() ? $("#admin_company_input").val() : '';
                let formData = new FormData();
                formData.append('template_name', template_name);
                formData.append('email_subject', email_subject);
                formData.append('email_body', email_body);
                formData.append('status', status);
                formData.append('email_attachment', email_attachment);
                formData.append('sender_name', sender_name);
                formData.append('body_type', body_type);
                formData.append('sender_email', sender_email);
                formData.append('company', company);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('createEmailTemplate') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.message,
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'Close'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                hideModal('add-email-templates-modal');
                                getEmailTemplates();
                            }
                        });
                        hideModal('add-email-templates-modal');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errorMessage = JSON.parse(xhr.responseText) ? JSON.parse(xhr.responseText) : xhr
                                .responseText;
                            var errors = errorMessage.errors ? errorMessage.errors : errorMessage;
                            $('#error_message_field').show();
                            $('#error_message').empty();
                            $.each(errors, function(field, messages) {
                                $.each(messages, function(index, message) {
                                    let data = `<li>${message}</li>`;
                                    $('#error_message').append(data);
                                });
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: xhr.responseJSON.message,
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close'
                            });
                        }
                    }
                });
            }

            function showTextArea(type) {

                if (type === 'text') {
                    $("#text-body").show();
                    $("#html-body").hide();
                } else {
                    $("#text-body").hide();
                    $("#html-body").show();
                }
            }

            function getEmailTemplates(page = 1) {
                emailTemplates = [];
                let status = $("#status").val();
                let show = $("#show").val();
                let search = $("#search").val();
                let companyId = $("#companyCheckAdmin").val();
                $.ajax({
                    url: "{{ route('getEmailTemplate') }}" + "?page=" + page,
                    type: 'GET',
                    data: {
                        status: status,
                        show: show,
                        search: search,
                        page: page,
                        companyId: companyId
                    },
                    success: function(response) {
                        $('#list-email-templates-tbody').empty();
                        emailTemplates = response.data;

                        if (emailTemplates.length === 0) {
                            $('#list-email-templates-tbody').append(
                                `<tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                            <td class="p-4" colspan="6">No data available</td>
                        </tr>`
                            );
                        } else {
                            Object.keys(emailTemplates).forEach(function(key) {
                                let button = ''; // Initialize the button variable
                                let emailTemplate = emailTemplates[key];
                                if ($("#status").val() == 1) {
                                    button =
                                        `
                            <button onclick="showEditEmailTemplatesModal(${emailTemplate.id})"
                                class="px-4 me-2 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Edit</button>`;
                                } else {
                                    button = `
                            <button onclick="ActivateEmailTemplate(${emailTemplate.id})"
                                class="px-4 me-2 py-2 text-xs md:text-sm font-medium text-white bg-yellow-600 rounded-xl hover:bg-yellow-700 dark:bg-yellow-500 dark:hover:bg-yellow-600">Activate</button>
                            `;
                                }

                                let sender = separateEnvelope(emailTemplate.envelope_sender);
                                let data = `
                        <tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                            <td class="p-4">${emailTemplate.name}</td>
                            <td class="p-4">${sender.name}</td>
                            <td class="p-4">${sender.email}</td>
                            <td class="p-4">${emailTemplate.subject}</td>
                            @CanModifyEmailTemplate()
                            <td class="p-4 flex gap-2">
                                @CanUpdateEmailTemplate()
                                ${button} 
                                @endCanUpdateEmailTemplate()
                                @CanDeleteEmailTemplate()
                                <button onclick="removeEmailTemplate(${emailTemplate.id})"
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Remove</button>
                                @endCanDeleteEmailTemplate()
                                    </td>
                            @endCanModifyEmailTemplate
                            
                        </tr>`;
                                $('#list-email-templates-tbody').append(data);
                            });

                        }
                        $("#numberFirstItem").text(
                            response.templateTotal != 0 ? (page - 1) * $("#show").val() + 1 : 0
                        );
                        $("#numberLastItem").text(
                            (page - 1) * $("#show").val() + response.data.length
                        );
                        $("#totalTemplatesCount").text(response.templateTotal);

                        $('#page-button-email-templates-company').empty();
                        paginationTemplateCompany("#page-button-email-templates-company", response.pageCount,
                            response.currentPage);
                    }
                });
            }

            function showAttachmentFileNameCreate() {
                let file = $("#email_attachment")[0].files[0];
                console.log(file)
                $("#attachment-file").empty();
                $("#attachment-file").append(
                    `<div class="group-member flex items-center justify-between mb-4 shadow-md p-3 rounded-xl">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">
                                            ${file.name}</p>

                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-100">
                                            ${file.type}</p>
                                    </div>
                                    <div>
                                        <button type="button"  onclick="removeAttachment()"
                                            class="remove-user focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Remove</button>

                                    </div>
                                </div>`
                );
            }

            function showAttachmentFileNameEdit(value) {
                console.log(value)
                $("#attachment-file").empty();
                $("#attachment-file").append(
                    `<div class="group-member flex items-center justify-between mb-4 shadow-md p-3 rounded-xl">
                            <input type="hidden" id="img-file" data-content="${value.content}" data-title="${value.name}" data-type="${value.type}">
                                    <div class="flex flex-col gap-1">

                                        <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">
                                            ${value.name}</p>

                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-100">
                                            ${value.type}</p>
                                    </div>
                                    <div>
                                        <button type="button"  onclick="removeAttachment()"
                                            class="remove-user focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Remove</button>

                                    </div>
                                </div>`
                );
            }

            function separateEnvelope(sender) {
                let regex = /^(.*?)<(.+?)>$/;
                let matches = sender.match(regex);
                let name = $.trim(matches[1]);
                let email = $.trim(matches[2]);
                return {
                    name: name,
                    email: email
                };
            }


            function showEditEmailTemplatesModal(id) {
                let emailTemplate = emailTemplates.find(x => x.id === id);
                console.log(emailTemplate);
                $("#template_name").val(emailTemplate.name);
                $("#email_subject").val(emailTemplate.subject);
                $("#email_text").val(emailTemplate.text);
                $("#email_html").val(emailTemplate.html);
                $("#email_status").val(1);
                $("#sender_name").val(separateEnvelope(emailTemplate.envelope_sender).name);
                $("#sender_email").val(separateEnvelope(emailTemplate.envelope_sender).email);
                $("#error_message_field").hide();
                $("#email_status").prop('disabled', true);
                $("#title-add-email-templates-modal").text('Edit Email Templates');
                $("#button-for-email-template").text('Update');
                $("#button-for-email-template").removeAttr('onclick').attr('onclick',
                    `editEmailTemplates(${id})`);
                $("#email_status").prop('disabled', false);
                showAttachmentFileNameEdit(emailTemplate.attachments[0]);
                showModal('add-email-templates-modal');



            }

            function removeAttachment() {
                $("#email_attachment").val('');
                $("#attachment-file").empty();
            }

            function editEmailTemplates(ids) {
                let old_email_attachment = null;
                let json_email = null;
                let id = ids;
                let template_name = $("#template_name").val();
                let email_subject = $("#email_subject").val();
                let email_text = $("#email_text").val();
                let email_html = $("#email_html").val();
                let status = $("#email_status").val();
                let sender_name = $("#sender_name").val();
                let sender_email = $("#sender_email").val();
                let email_attachment = $("#email_attachment")[0].files[0];
                if ((email_attachment === undefined || email_attachment === null) && $("#img-file").data('content') !==
                    undefined) {
                    email_attachment = '';
                    old_email_attachment = {
                        content: $("#img-file").data('content'),
                        name: $("#img-file").data('title'),
                        type: $("#img-file").data('type')
                    }
                    json_email = JSON.stringify(old_email_attachment);
                } else if ((email_attachment === undefined || email_attachment === null) && $("#img-file").data('content') ===
                    undefined) {
                    email_attachment = '';
                } else {}
                let formData = new FormData();
                formData.append('id', id);
                formData.append('template_name', template_name);
                formData.append('email_subject', email_subject);
                formData.append('email_text', email_text);
                formData.append('email_html', email_html);
                formData.append('status', status);
                formData.append('old_email_attachment', json_email);
                formData.append('email_attachment', email_attachment);
                formData.append('sender_name', sender_name);
                formData.append('sender_email', sender_email);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('updateEmailTemplate') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.message,
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'Close'
                        })


                        getEmailTemplates();

                        hideModal('add-email-templates-modal');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errorMessage = JSON.parse(xhr.responseText) ? JSON.parse(xhr.responseText) : xhr
                                .responseText;
                            var errors = errorMessage.errors ? errorMessage.errors : errorMessage;
                            $('#error_message_field').show();
                            $('#error_message').empty();
                            $.each(errors, function(field, messages) {
                                $.each(messages, function(index, message) {
                                    let data = `<li>${message}</li>`;
                                    $('#error_message').append(data);
                                });
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: xhr.responseJSON.message,
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close'
                            });
                        }
                    }
                })
            }

            function removeEmailTemplate(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to remove this email template!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#d97706',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('deleteEmailTemplate') }}",
                            type: 'POST',
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: response.message,
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: 'Close'
                                });
                                getEmailTemplates();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: xhr.responseJSON.message,
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: 'Close'
                                });
                            }
                        });
                    }
                });
            }

            function ActivateEmailTemplate(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to activate this email template!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#d97706',
                    confirmButtonText: 'Yes, activate it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('activateEmailTemplate') }}",
                            type: 'POST',
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Success",
                                    text: response.message,
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: 'Close'
                                });
                                getEmailTemplates();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error",
                                    text: xhr.responseJSON.message,
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: 'Close'
                                });
                            }
                        });
                    }
                });
            }

            function showEmailTemplateDetails(id) {
                let emailTemplate = emailTemplates.find(x => x.id === id);
                console.log(emailTemplate);
            }
        </script>
    @endsection
