@extends('layouts.master')
@section('title', 'Campaign')
@section('content')
    @include('contents.modal.campaign.add-campaign-modal')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Campaigns</h1>
                <div>
                    <button onclick="showAddCampaignModal()"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Create
                        Campaign</button>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-xs">
                    <div>
                        <label for="status"
                            class="mb-1 mt-4 block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status" onchange="getCampaigns()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex p-4 justify-between items-center mt-8">
                <div class="flex items-center">
                    <label for="show" class="mr-2 text-sm font-medium">Show</label>
                    <select id="show" name="show" onchange="getCampaigns()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <input type="text" id="search" name="search" onchange="getCampaigns()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search...">
                </div>
            </div>
            <div class="p-4 min-w-32 overflow-x-auto md:min-w-full">
                <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                    <thead class="bg-gray-300 dark:bg-gray-700">
                        <tr
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                            <th scope="col" class="p-4">Campaign Name</th>
                            <th scope="col" class="p-4">Template</th>
                            <th scope="col" class="p-4">Launch Date</th>
                            <th scope="col" class="p-4">End Date</th>
                            <th scope="col" class="p-4">Sending Profile</th>
                            <th scope="col" class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody id="list-campaign-tbody"
                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                    </tbody>
                </table>
            </div>
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4"
                aria-label="Table navigation">
                <span
                    class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing
                    <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">0</span> - <span
                            id="numberLastItem">0</span></span> of
                    <span id="totalTemplatesCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                </span>
                <ul id="page-button-campign-company" class="inline-flex space-x-2 rtl:space-x-reverse text-sm h-8">

                </ul>
            </nav>
        </div>
    </div>

    <script>
        let landingPages = [];
        let emailTemplates = [];
        let sendingProfiles = [];
        let groups = [];
        let campaigns = [];
        $(document).ready(function() {
            // getCampaigns();
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

        function testConnection() {
            Swal.fire({
                title: 'Testing...',
                text: 'Please wait while we test your email profile.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let id = $("#campaign_profile").val();

            // Set a timeout for 10 seconds (10000 milliseconds)
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
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    clearTimeout(timeout); // Clear the timeout when the request is successful
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
                    clearTimeout(timeout); // Clear the timeout if there is an error
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
    </script>
@endSection
