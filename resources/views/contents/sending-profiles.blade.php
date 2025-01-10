@extends('layouts.master')
@section('title', 'Sending Profiles')
@section('content')
    @include('contents.modal.sending-profile.add-sending-profile-modal')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Sending Profiles</h1>
                <div>
                    <button onclick="showAddSendingProfileModal()"
                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 md:hidden">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="hidden md:inline ml-2">Create Profile</span>
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="md:max-w-xs max-w-full">
                    <div>
                        <label for="status"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status" onchange="getSendingProfile()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                @IsAdmin()
                <div class="md:max-w-xs max-w-full">
                    <div>
                        <label for="companyCheckAdmin"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                        <select id="companyCheckAdmin" name="companyCheckAdmin" onchange="getSendingProfile()"
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
                        <select id="show" name="show" onchange="getSendingProfile()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getSendingProfile()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class="min-w-32 overflow-x-auto md:min-w-full">
                    <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                <th scope="col" class="p-4">Profile Name</th>
                                <th scope="col" class="p-4">Username</th>
                                <th scope="col" class="p-4">Host</th>
                                <th scope="col" class="p-4">From Address</th>
                                <th scope="col" class="p-4">Ignore Certificate</th>
                                <th scope="col" class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody id="list-sending-profile-tbody"
                            class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                        </tbody>
                    </table>
                </div>
                <nav class="flex items-center flex-column flex-col md:flex-row justify-between p-4" aria-label="Table navigation">
                    <span
                        class="mb-4 md:mb-0 text-xs md:text-sm font-normal text-gray-500 dark:text-gray-400 block w-full md:inline md:w-auto">Showing
                        <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">0</span> -
                            <span id="numberLastItem">0</span></span> of
                        <span id="totalTemplatesCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                    </span>
                    <ul id="page-button-sending-profile-company"
                        class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        let sendingProfiles = [];
        $(document).ready(function() {
            getSendingProfile();
        });

        function showAddSendingProfileModal() {
            $("#button-for-profile").removeAttr('onclick').attr('onclick', 'addSendingProfile()');
            $("#sending-profile-form input").val("");
            $("#interface_type").val("smtp");
            $("#http-header-list").empty();
            $(".for-edit-profile").hide();
            $(".for-create-profile").show();
            $("#error-http-header").hide();
            $("#header_email").val("");
            $("#header_value").val("");
            $("#error-message-field").hide();
            $("#button-for-profile").text('Add');
            $("#title-add-sending-profile-modal").text('Create Sending Profile')
            showModal('add-sending-profile-modal');

        }

        function addHttpHeader() {
            let checkValue = $("#header_email").val() != "" && $("#header_value").val() != "";
            if (checkValue) {
                let header_email = $("#header_email").val();
                let header_value = $("#header_value").val();
                let id = $("#http-header-list").children().last().attr('value') ? parseInt($("#http-header-list").children()
                    .last().attr('value')) + 1 : 1;
                let html = ` <div class="http-header flex items-center justify-between mb-4 shadow-md p-3 rounded-xl"
                        value="${id}" id="http_header_${id}" data-header="${header_email}" data-value="${header_value}">
                        <div class="flex flex-col gap-1">
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">${header_email}</p>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-100">${header_value}</p>
                        </div>
                        <div>
                            <button type="button" data-value="${id}" onclick="removeHttpHeader(${id})"
                                class="remove-user focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Remove</button>
                        </div>
                    </div>`;
                $("#http-header-list").append(html);
                $("#header_email").val("");
                $("#header_value").val("");
                $("#error-http-header").hide();
            } else {
                $("#error-http-header").show();
            }
        }

        function removeHttpHeader(id) {
            $(`#http_header_${id}`).remove();
        }

        function addSendingProfile() {
            let profile_name = $("#profile_name").val();
            let interface_type = $("#interface_type").val();
            let email_smtp = $("#email_smtp").val();
            let first_name_smtp = $("#first_name_smtp").val();
            let last_name_smtp = $("#last_name_smtp").val();
            let host = $("#smtp_host").val();
            let ignore_certificate = $("#ignore_certificate").val();
            let username = $("#username_profile").val();
            let password = $("#password_profile").val();
            let http_headers = [];
            $("#http-header-list").children().each(function() {
                let header_email = $(this).data('header');
                let header_value = $(this).data('value');
                http_headers.push({
                    header_email,
                    header_value
                });
            });

            $.ajax({
                url: "{{ route('createSendingProfile') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    profile_name,
                    interface_type,
                    email_smtp,
                    host,
                    ignore_certificate,
                    username,
                    password,
                    http_headers

                },
                success: function(response) {

                    getSendingProfile();
                    hideModal('add-sending-profile-modal');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Sending Profile has been added successfully',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Close'

                    })
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

        function getSendingProfile(page = 1) {
            let show = $("#show").val();
            let search = $("#search").val();
            let status = $("#status").val();
            let companyId = $("#companyCheckAdmin").val();
            $.ajax({
                url: "{{ route('getSendingProfile') }}?page=" + page,
                type: "GET",
                data: {
                    show,
                    search,
                    status,
                    page,
                    companyId
                },
                success: function(response) {
                    console.log(response)
                    sendingProfiles = [];
                    sendingProfiles = response.data;
                    $("#list-sending-profile-tbody").empty();

                    if (sendingProfiles.length == 0) {
                        let data = `
                        <tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                            <td class="p-4" colspan="6">No data available</td>
                        </tr>`;
                        $('#list-sending-profile-tbody').append(data);
                    } else {
                        Object.keys(sendingProfiles).forEach(function(key) {
                            let button = '';
                            let sendingProfile = sendingProfiles[key];

                            if ($("#status").val() == 1) {
                                button =
                                    `
                            <button onclick="showEditSendingProfileModal(${sendingProfile.id})"
                                class="px-4 me-2 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Edit</button>
                                
                                `;
                            } else {
                                button = `
                            <button onclick="activateSendingProfile(${sendingProfile.id})"
                                class="px-4 me-2 py-2 text-xs md:text-sm font-medium text-white bg-yellow-600 rounded-xl hover:bg-yellow-700 dark:bg-yellow-500 dark:hover:bg-yellow-600">Activate</button>
                            `;
                            }
                            let data = `
                        <tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                            <td class="p-4">${sendingProfile.name}</td>
                            <td class="p-4">${sendingProfile.username ?? 'Not Set'}</td>
                            <td class="p-4">${sendingProfile.host}</td>
                            <td class="p-4">${sendingProfile.from_address}</td>
                            <td class="p-4">${sendingProfile.ignore_cert_errors}</td>
                            <td class="p-4 flex gap-2">
                                ${button} 
                                <button onclick="deleteSendingProfile(${sendingProfile.id})"
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Remove</button>
                            </td>
                        </tr>`;
                            $('#list-sending-profile-tbody').append(data);
                        });
                    }
                    paginationSendingProfile("#page-button-sending-profile-company", response.pageCount,
                        response.currentPage);
                    $("#numberFirstItem").text(
                        response.profileTotal != 0 ? (page - 1) * $("#show").val() + 1 : 0
                    );
                    $("#numberLastItem").text(
                        (page - 1) * $("#show").val() + response.data.length
                    );
                    $("#totalTemplatesCount").text(response.profileTotal);


                }
            });
        }

        function showEditSendingProfileModal(id) {
            let sendingProfile = sendingProfiles.find(x => x.id == id);
            let headers = sendingProfile.headers
            let sender = sendingProfile.from_address;
            $("#profile_name").val(sendingProfile.name);
            $("#interface_type").val(sendingProfile.interface_type);
            $("#email_smtp").val(sender);
            $("#smtp_host").val(sendingProfile.host);
            $("#ignore_certificate").val(sendingProfile.ignore_cert_errors == true ? 1 : 0);
            $("#username_profile").val(sendingProfile.username);
            $("#password_profile").val(sendingProfile.password);
            $("#http-header-list").empty();
            headers.forEach(function(header) {
                let id = $("#http-header-list").children().last().attr('value') ? parseInt($("#http-header-list")
                    .children()
                    .last().attr('value')) + 1 : 1;
                let html = ` <div class="http-header flex items-center justify-between mb-4 shadow-md p-3 rounded-xl"
                        value="${id}" id="http_header_${id}" data-header="${header.key}" data-value="${header.value}">
                        <div class="flex flex-col gap-1">
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">${header.key}</p>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-100">${header.value}</p>
                        </div>
                        <div>
                            <button type="button" data-value="${id}" onclick="removeHttpHeader(${id})"
                                class="remove-user focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Remove</button>
                        </div>
                    </div>`;
                $("#http-header-list").append(html);
            });
            $("#button-for-profile").removeAttr('onclick').attr('onclick', `editSendingProfile(${id})`);
            $("#button-for-profile").text('Update');
            $(".for-edit-profile").show();
            $(".for-create-profile").hide();
            $("#error-http-header").hide();
            $("#error-message-field").hide();
            $("#header_email").val("");
            $("#header_value").val("");
            $("#title-add-sending-profile-modal").text('Edit Sending Profile');
            $("#error_message_field").hide();
            showModal('add-sending-profile-modal');

        }

        function editSendingProfile(id) {
            let name = $("#profile_name").val();
            let interface_type = $("#interface_type").val();
            let email = $("#email_smtp").val();
            let status = $("#profile_status").val();
            let host = $("#smtp_host").val();
            let ignore_cert_errors = $("#ignore_certificate").val();
            let username = $("#username_profile").val();
            let password = $("#password_profile").val();
            let http_headers = []
            $("#http-header-list").children().each(function() {
                let header_email = $(this).data('header');
                let header_value = $(this).data('value');
                http_headers.push({
                    header_email,
                    header_value
                });
            });
            console.log(http_headers)
            $.ajax({
                url: "{{ route('updateSendingProfile') }}",
                type: "POST",
                data: {
                    id,
                    name,
                    interface_type,
                    email,
                    status,
                    host,
                    ignore_cert_errors,
                    username,
                    password,
                    http_headers,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    getSendingProfile();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Sending Profile has been updated!',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Close'
                    });
                    hideModal('add-sending-profile-modal');
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

        function deleteSendingProfile(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#d97706',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteSendingProfile') }}",
                        type: "POST",
                        data: {
                            id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            getSendingProfile();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Sending Profile has been deleted!',
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close'
                            });
                        }
                    });
                }
            })
        }

        function activateSendingProfile(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to activate this sending profile?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#d97706',
                confirmButtonText: 'Yes, activate it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('activateSendingProfile') }}",
                        type: "POST",
                        data: {
                            id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            getSendingProfile();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Sending Profile has been activated!',
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close'
                            });
                        }
                    });
                }
            })
        }

        function testMail() {
            Swal.fire({
                title: 'Testing...',
                text: 'Please wait while we test your input.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            let profile_name = $("#profile_name").val();
            let interface_type = $("#interface_type").val();
            let email_smtp = $("#email_smtp").val();
            let host = $("#smtp_host").val();
            let ignore_certificate = $("#ignore_certificate").val();
            let username = $("#username_profile").val();
            let password = $("#password_profile").val();
            let http_headers = [];
            $("#http-header-list").children().each(function() {
                let header_email = $(this).data('header');
                let header_value = $(this).data('value');
                http_headers.push({
                    header_email,
                    header_value
                });
            });
            let timeout = setTimeout(() => {
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "Response Took Too Long",
                    text: "The connection is taking longer than expected. Please check your input.",
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Close'
                });
            }, 10000);
            $.ajax({
                url: "{{ route('testSendingProfile') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    profile_name,
                    interface_type,
                    email_smtp,
                    host,
                    ignore_certificate,
                    username,
                    password,
                    http_headers

                },
                success: function(response) {
                    clearTimeout(timeout);
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Success! The test email has been sent successfully!',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Close'

                    })
                },
                error: function(xhr) {
                    clearTimeout(timeout);
                    Swal.close();
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
                        let errorMessage = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: errorMessage.error,
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'Close'
                        });
                        console.log(errorMessage)
                    }
                }
            })
        }
    </script>
@endsection
