@extends('layouts.master')
@section('title', 'Fischsim - Approval')
@section('content')
    @include('contents.modal.approval.approval-action-modal')
    @include('contents.modal.notes.notes-modal')
    <div class="bg-white dark:bg-gray-800 min-h-screen  p-4 w-full dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Campaign Approval</h1>
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="status"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status_filter" name="status" onchange="getAllApproval()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All</option>
                            <option value="1">Pending</option>
                            <option value="2">Approved</option>
                            <option value="3">Rejected</option>
                        </select>
                    </div>

                </div>
                <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                    <div class="flex md:flex-row flex-col items-start md:items-center mb-4 md:mb-0">
                        <label for="show" class="mr-2 text-xs md:text-sm font-medium mb-2 md:mb-0">Show</label>
                        <select id="show" name="show" onchange="getAllApproval()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getAllApproval()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class="min-w-32 overflow-x-auto md:min-w-full">
                    <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                <th scope="col" class="p-4">Campaign Name</th>
                                <th scope="col" class="p-4">Status</th>
                                <th scope="col" class="p-4">Launch Date</th>
                                <th scope="col" class="p-4">Template</th>
                                <th scope="col" class="p-4">Address</th>
                                <th scope="col" class="p-4">Page</th>
                                <th scope="col" class="p-4">Group</th>
                                <th scope="col" class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody id="list-approval-tbody"
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
                        <span id="totalCompanyCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                    </span>
                    <ul id="page-button-approval" class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        let approvals = [];
        $(document).ready(function() {
            $("#status_filter").val(1);
            getAllApproval();
        });

        function getAllApproval(page = 1) {
            let status = $("#status_filter").val();
            let show = $("#show").val();
            let search = $("#search").val();
            $.ajax({
                url: "{{ route('getApproval') }}",
                type: "GET",
                data: {
                    status: status,
                    show: show,
                    search: search,
                    page: page
                },
                success: function(response) {
                    approvals = response.approvals;
                    $("#list-approval-tbody").empty();
                    if (approvals.length == 0) {
                        $("#list-approval-tbody").append(`
                         <tr class="text-xs md:text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4" colspan="5">
                                    No data available
                                </td>
                            </tr>
                            `);
                    } else {
                        approvals.forEach(function(approval) {
                            let tempApproval = JSON.parse(approval.data);
                            let launchDate = new Date(tempApproval.launch_date).toLocaleString(
                                'en-US', {
                                    weekday: 'long',
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });
                            let addressName = tempApproval.smtp['name'].split('-+-')[0];
                            let pageName = tempApproval.page['name'];
                            let templateName = tempApproval.template['name'].split('-+-')[0];
                            let group = `
                                        <td class="relative group p-4 ">
                                            ${(tempApproval.groups.length) } Groups
                                            <div class="absolute hidden group-hover:block text-black bg-white dark:bg-gray-800 dark:text-white text-sm rounded-lg p-2 shadow-lg w-max max-w-xs z-50 -top-10 left-1/2 transform -translate-x-1/2">
                                                <ul class="list-disc list-inside">
                                                    ${tempApproval.groups.map(group => group.name ? `<li>${(group.name).split('-+-')[0]}</li>` : '').join('')}
                                                </ul>
                                            </div>
                                        </td>`;

                            let button = ''
                            if (approval.status_id == 1) {
                                button = `  <td class="p-4 gap-2">
                                            <button onclick="showActionModal(${approval.id})"
                                                class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-orange-600 rounded-xl hover:bg-orange-700 dark:bg-orange-500 dark:hover:bg-orange-600">Action</button>
                                           
                                        </td>`;
                            } else if (approval.status_id == 3) {
                                button = `<td class="p-4">
                                    <button onclick="showNotes(${approval.id})"
                                            class=" text-xs md:text-sm font-medium text-white bg-transparent-600 rounded-xl hover:bg-transparent-700 dark:bg-transparent-500 dark:hover:bg-transparent-600">
                                           <div class="relative group">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-gray-400 dark:text-white">
                                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded-md">Notes</span>
                                                </div>
                                        </button></td>`;
                            }

                            let status = '';
                            if (approval.status_id == 1) {
                                status =
                                    `<div class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 inline-block">Pending
                                            </div>`;
                            } else if (approval.status_id == 2) {
                                status =
                                    `<div class="bg-red-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">Approved
                                            </div>`;
                            } else {
                                status =
                                    `<div class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 inline-block">Rejected
                                            </div>`;
                            }




                            $("#list-approval-tbody").append(`
                                    <tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                                            <td class="p-4 truncate max-w-xs" title="${tempApproval.name}">${tempApproval.name}</td>
                                            <td class="p-4 truncate max-w-xs" >${status}</td>
                                            <td class="p-4 truncate max-w-xs" title="${launchDate}">${launchDate}</td>
                                            <td class="p-4 truncate max-w-xs" title="${templateName}">${templateName}</td>
                                            <td class="p-4 truncate max-w-xs" title="${pageName}">${pageName}</td>
                                            <td class="p-4 truncate max-w-xs" title="${addressName}">${addressName}</td>
                                            ${group}
                                            ${button}
                                    `);
                        });
                        $("#numberFirstItem").text(
                            response.approvals != 0 ? (page - 1) * $("#show").val() + 1 : 0
                        );
                        $("#numberLastItem").text(
                            (page - 1) * $("#show").val() + response.approvals.length
                        );
                        $("#totalCompanyCount").text(response.totalApproval);
                        paginationApproval("#page-button-approval", response.pageCount, response.currentPage);

                    }
                },
                error: function(response) {
                    console.log(response);
                }

            })
        }

        function showActionModal(id) {
            $("#campaign_id").val(id);
            $("#company_id").val(approvals.find(approval => approval.id == id).company_id);
            showModal('action-approval-modal');

        }

        function submitActionApproval() {
            let status = $("input[name='default-radio']:checked").val();
            let message = $("#message").val();
            let id = $("#campaign_id").val();
            let company_id = $("#company_id").val();
            $.ajax({
                url: "{{ route('actionApproval') }}",
                type: "POST",
                data: {
                    status: status,
                    message: message,
                    id: id,
                    company_id: company_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    hideModal('action-approval-modal');
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: response.message,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Close'
                    });
                    getAllApproval();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        var errorMessage = JSON.parse(xhr.responseText) ? JSON.parse(xhr.responseText) : xhr
                            .responseText;
                        var errors = errorMessage.message ? errorMessage.message : errorMessage;
                        $('#error_message_field').show();
                        $('#error_message').empty();
                        $('#error_message').append(`<li>${errors}</li>`);
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


        function showNotes(id) {
            $("#campaign_notes").val('');
            let notes = approvals.find(approval => approval.id == id).notes;
            if (notes) {
                $("#campaign_notes").val(notes);
            }
            else{
                $("#campaign_notes").val('Campaign has been rejected');
            }
            $("#campaign_notes").attr('disabled', true);
            showModal('notes-modal');
        }
    </script>
@endSection
