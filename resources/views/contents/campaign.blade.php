@extends('layouts.master')
@section('title', 'Campaign')
@section('content')
    @include('contents.modal.campaign.add-campaign-modal')
    @include('contents.modal.sending-profile.test-connection')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Campaigns</h1>
                @CanCreateCampaign
                <div>
                    <button onclick="showAddCampaignModal()"
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
                @endCanCreateCampaign
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="status"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status" onchange="getCampaigns()"
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
                        <select id="companyCheckAdmin" name="companyCheckAdmin" onchange="getCampaigns()"
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
                        <select id="show" name="show" onchange="getCampaigns()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getCampaigns()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class=" min-w-32 overflow-x-auto md:min-w-full">
                    <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                <th scope="col" class="p-4">Campaign Name</th>
                                <th scope="col" class="p-4">Status</th>
                                <th scope="col" class="p-4">Launch Date</th>
                                <th scope="col" class="p-4">From Address</th>
                                <th scope="col" class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody id="list-campaign-tbody"
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
                    <ul id="page-button-campaign-company"
                        class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">
                    </ul>
                </nav>
            </div>
        </div>
    </div>


    <script>
        let landingPages = [];
        let emailTemplates = [];
        let sendingProfiles = [];
        let groups = [];
        let campaigns = [];

        $(document).ready(function() {
            getCampaigns();
            getCampaignsResources();
        });

        function showAddCampaignModal() {
            showModal('add-campaign-modal');
        }

        function getCampaignsResources() {
            $.ajax({
                url: "{{ route('getCampaignResources') }}",
                type: "GET",
                success: function(response) {
                    landingPages = response.landingPages;
                    emailTemplates = response.emailTemplates;
                    sendingProfiles = response.sendingProfiles;
                    groups = response.groups;
                    $("#campaign_page").empty();
                    $("#campaign_template").empty();
                    $("#campaign_profile").empty();
                    $("#group_campaign").empty();
                    $("#campaign_page").append(
                        `<option value="">Select Landing Page</option>`
                    );
                    $("#campaign_template").append(
                        `<option value="">Select Template</option>`
                    );
                    $("#campaign_profile").append(
                        `<option value="">Select Profile</option>`
                    );
                    $("#group_campaign").append(
                        `<option value="">Select Group</option>`
                    );
                    landingPages.forEach(data => {
                        $("#campaign_page").append(
                            `<option value="${data.id}">${data.name}</option>`
                        );
                    });
                    emailTemplates.forEach(data => {
                        $("#campaign_template").append(
                            `<option value="${data.id}">${data.name}</option>`
                        );
                    });
                    sendingProfiles.forEach(data => {
                        $("#campaign_profile").append(
                            `<option value="${data.id}">${data.name}</option>`
                        );
                    });

                    groups.forEach(data => {
                        $("#group_campaign").append(
                            `<option value="${data.id}">${data.name}</option>`
                        );
                    });
                }
            })
        }

        function addGroupToCampaign(id) {
            let tempGroup = groups.find(group => group.id == id);
            $("#group-list").append(`
                        <div class="group-campaign flex items-center justify-between mb-4 shadow-md p-3 rounded-xl"
                            value="${tempGroup.id}" id="group_member_${tempGroup.id}">
                            <div class="flex flex-col gap-1">
                                <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">${tempGroup.name}</p>
                            </div>
                            <div>
                                <button type="button" data-value="${tempGroup.id}" onclick="removeGroup(${tempGroup.id})"
                                    class="remove-user focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Remove</button>

                            </div>
                        </div>
                `);
            setGroupSelection();
        }

        function setGroupSelection() {
            $("#group_campaign").empty();
            $("#group_campaign").append(
                `<option value="">Select Group</option>`
            );
            groups.forEach(function(group) {
                $("#group_campaign").append(
                    `<option value="${group.id}">${group.name}</option>`
                );
            });
            $(".group-campaign").each(function() {
                let id = $(this).attr('value');
                $("#group_campaign option").each(function() {
                    if ($(this).val() == id) {
                        $(this).remove();
                    }
                });
            })
        }

        function removeGroup(id) {
            $(`#group_member_${id}`).remove();
            setGroupSelection();
        }

        function testMail() {
            Swal.fire({
                title: 'Testing...',
                text: 'Please wait while we test your email profile.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let id = $("#campaign_profile").val();
            let name = $("#test_name").val();
            let email = $("#test_email").val();
            let timeout = setTimeout(() => {
                Swal.close();
                Swal.fire({
                    icon: "error",
                    title: "Response Took Too Long",
                    text: "The connection is taking longer than expected. Please check your email profile.",
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Close'
                });
            }, 10000);

            $.ajax({
                url: "{{ route('testConnection') }}",
                type: "POST",
                data: {
                    id: id,
                    name: name,
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    clearTimeout(timeout);
                    Swal.close();
                    Swal.fire({
                        title: 'Success',
                        text: 'Connection is successful.',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    clearTimeout(timeout);
                    Swal.close();
                    let errorMessage = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: errorMessage.error,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Close'
                    });
                }
            })
        }

        function createCampaign() {
            let name = $("#campaign_name").val();
            let template = $("#campaign_template").val();
            let page = $("#campaign_page").val();
            let launchDate = $("#campaign_launch_date").val();
            let endDate = $("#campaign_end_date").val();
            let url = $("#campaign_url").val();
            let status = $("#campaign_status").val();
            let profile = $("#campaign_profile").val();
            let groups = [];
            $(".group-campaign").each(function() {
                groups.push($(this).attr('value'));
            });
            $.ajax({
                url: "{{ route('createCampaign') }}",
                type: "POST",
                data: {
                    name: name,
                    template: template,
                    page: page,
                    launchDate: launchDate,
                    endDate: endDate,
                    url: url,
                    status: status,
                    profile: profile,
                    groups: groups,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success',
                        text: 'Campaign created successfully.',
                        icon: 'success',
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'OK'
                    });
                    hideModal('add-campaign-modal');
                    getCampaigns();
                },
                error: function(xhr, status, error) {
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

        function getCampaigns(page = 1) {
            let show = $("#show").val();
            let search = $("#search").val();
            let status = $("#status").val();
            let company = $("#companyCheckAdmin").val();
            $.ajax({
                url: "{{ route('getCampaigns') }}?page=" + page,
                type: "GET",
                data: {
                    show: show,
                    search: search,
                    status: status,
                    page: page,
                    companyId: company
                },
                success: function(response) {
                    campaigns = [];
                    campaigns = response.data;
                    $("#list-campaign-tbody").empty();
                    if (campaigns.length == 0) {
                        $("#list-campaign-tbody").append(`
                            <tr class="text-xs md:text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4" colspan="5">
                                    No data available
                                </td>
                            </tr>
                        `);
                    } else {
                        campaigns.forEach(function(campaign) {
                            console.log(campaign);
                            let date = new Date(campaign.launch_date);
                            let formattedStatus = '';
                            let formattedDate =
                                `${date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        })} ${String(date.getUTCHours() + 7).padStart(2, '0')}:${String(date.getUTCMinutes()).padStart(2, '0')}`;

                            if (campaign.status === 'In progress') {
                                formattedStatus = `<div class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 inline-block">
                                                In Progress
                                            </div>`
                            } else if (campaign.status === 'Queued') {
                                formattedStatus = `<div class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 inline-block">
                                                Scheduled
                                            </div>`
                            } else {
                                formattedStatus = `<div class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">
                                                Completed
                                            </div>`
                            }
                            $("#list-campaign-tbody").append(`
                            <tr class="text-xs md:text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4">
                                   ${campaign.name}
                                </td>
                                <td class="p-4">
                                    ${formattedStatus}
                                </td>
                                <td class="p-4">
                                    ${formattedDate}
                                </td>
                                <td class="p-4">
                                    ${campaign.smtp.from_address}
                                </td>
                                    <td class="p-4">
                                        <div class="flex items-center">
                                            <button onclick="showDetailCampaign(${campaign.id})" class="px-4 me-2 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">Details</button>
                                        @CanDeleteCampaign()
                                            <button onclick="deleteCampaign(${campaign.id})" class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Delete</button>
                                        @endCanDeleteCampaign()
                                    </div>
                                </td>
                            </tr>
                        `);
                        });
                    }
                    $("#numberFirstItem").text(
                        response.campaignTotal != 0 ? (page - 1) * $("#show").val() + 1 : 0
                    );
                    $("#numberLastItem").text(
                        (page - 1) * $("#show").val() + response.data.length
                    );
                    $("#totalTemplatesCount").text(response.campaignTotal);
                    paginationSendingProfile("#page-button-campaign-company", response.pageCount,
                        response.currentPage);
                }

            });
        }

        function deleteCampaign(id) {
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
                        url: "{{ route('deleteCampaign') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Campaign deleted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'OK'
                            });
                            getCampaigns();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: xhr.responseJSON.message,
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close'
                            });
                        }
                    })
                }
            })
        }

        function showDetailCampaign(id) {
            window.location.href = "{{ route('campaignDetailsView', '') }}/" + id;
        }

        function showTestConnectionModal() {
            showModal('test-connection-modal');
            $("#test_name").val('');
            $("#test_email").val('');
        }
    </script>
@endSection
