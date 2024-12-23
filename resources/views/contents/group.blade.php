@extends('layouts.master')
@section('title', 'Target')
@section('content')
    @include('contents.modal.group.add-group-modal')
    @include('contents.modal.group.details-group-modal')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Company Groups</h1>
                <div>
                    <button onclick="showAddGroupModal()"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Add
                        Group</button>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-xs">
                    <div>
                        <label for="status" class="mb-1 block text-sm font-medium">Status</label>
                        <select id="status" name="status" onchange="getGroups()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label for="department" class="mb-1 mt-4 block text-sm font-medium">Department</label>
                        <select id="department" name="department" onchange="getGroups()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </select>
                    </div>
                </div>
            </div>
            <div class="flex p-4 justify-between items-center mt-8">
                <div class="flex items-center">
                    <label for="show" class="mr-2 text-sm font-medium">Show</label>
                    <select id="show" name="show" onchange="getGroups()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <input type="text" id="search" name="search" onchange="getGroups()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search...">
                </div>
            </div>

            <table class="p-4 min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                <thead class="bg-gray-300 dark:bg-gray-700">
                    <tr
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                        <th scope="col" class="p-4">Group Name</th>
                        <th scope="col" class="p-4">Member</th>
                        <th scope="col" class="p-4">Department</th>
                        <th scope="col" class="p-4">Status</th>
                        <th scope="col" class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody id="list-groups-tbody"
                    class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                </tbody>
            </table>
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4"
                aria-label="Table navigation">
                <span
                    class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing
                    <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">0</span> - <span
                            id="numberLastItem">0</span></span> of
                    <span id="totalTemplatesCount" class="font-semibold text-gray-900 dark:text-white">0</span>
                </span>
                <ul id="pagination-group-button" class="inline-flex space-x-2 rtl:space-x-reverse text-sm h-8">

                </ul>
            </nav>
        </div>
    </div>

    <script>
        let targets = [];
        let tempTargets = [];
        let tempTargetValues = [];
        let groups = null;
        $(document).ready(function() {
            getGroupResources();
            getGroups();
        });

        function getGroupResources() {
            $.ajax({
                url: "{{ route('getGroupResources') }}",
                type: 'GET',
                success: function(response) {
                    let department = response.department;
                    targets = response.users;
                    setFilter(department, targets);

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function getGroups(page = 1) {
            let department = $('#department').val();
            let show = $('#show').val();
            let status = $('#status').val();
            let search = $('#search').val() ? $('#search').val() : '';
            $.ajax({
                url: "{{ route('getGroups') }}" + '?page=' + page,
                type: 'GET',
                data: {
                    department: department,
                    show: show,
                    status: status,
                    search: search
                },
                success: function(response) {
                    groups = response.groups;
                    $("#list-groups-tbody").empty();
                    groups.forEach(function(group) {
                        let status = group.status == 1 ? 'Active' : 'Inactive';
                        $("#list-groups-tbody").append(`
                            <tr class="text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4">${group.name}</td>
                                <td class="p-4">${group.target_count}</td>
                                <td class="p-4">${group.department.name}</td>
                                <td class="p-4">${status}</td>
                                <td class="p-4">
                                    <button onclick="showDetailsGroupModal(${group.id})" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">Details</button>
                                    <button onclick="showEditGroupModal(${group.id})" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Edit</button>
                                    <button onclick="showDeleteGroupModal(${group.id})" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Delete</button>
                                </td>
                            </tr>
                       `);
                    });
                    paginationGroupCompany("#pagination-group-button", response.pageCount, response
                        .currentPage);
                    $("#numberFirstItem").text(
                        response.targetTotal != 0 ? (page - 1) * $("#show").val() + 1 : 0
                    );
                    $("#numberLastItem").text(
                        (page - 1) * $("#show").val() + response.groups.length
                    );
                    $("#totalTemplatesCount").text(response.targetTotal);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function setFilter(department, users) {
            let departmentSelectModal = $('#group_department');
            departmentSelectModal.empty();
            departmentSelectModal.append('<option value="" selected>Select Department</option>');
            let departmentSelect = $('#department');
            departmentSelect.empty();
            departmentSelect.append('<option value=null selected>Select Department</option>');
            department.forEach(function(department) {
                departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
            });
            department.forEach(function(department) {
                departmentSelectModal.append('<option value="' + department.id + '">' + department.name +
                    '</option>');
            });
            // for target selection
            let usersSelectModal = $('#group_member');
            usersSelectModal.empty();
            usersSelectModal.append('<option value="" selected>Select User</option>');
            users.forEach(function(user) {
                usersSelectModal.append('<option value="' + user.id + '">' + user.first_name + ' ' + user
                    .last_name + '</option>');
            });
        }

        function showAddGroupModal() {
            showModal('add-group-modal');
            $("#group_name").val('');
            $("#group_department").val('');
            $("#group_status").val('1');
            $("#group_member_list").empty();
            $("#group_description").val('');
            $("#strict_user_selected_department").prop('checked', false);
            $("#title-add-group-modal").text('Add Group');
            $("#button-for-group").removeAttr('onclick').attr('onclick', 'createGroup()');
            setTargetSelection();
        }

        function showEditGroupModal(id) {
            tempGroup = groups.find(group => group.id == id);
            console.log(tempGroup);
            showModal('add-group-modal');
            $("#strict_user_selected_department").prop('checked', false);
            $("#title-add-group-modal").text('Edit Group');
            $("#button-for-group").removeAttr('onclick').attr('onclick', `updateGroup(${id})`);
            $("#button-for-group").text('Update');
            $("#group_name").val(tempGroup.name);
            $("#group_department").val(tempGroup.department_id);
            $("#group_status").val(tempGroup.status);
            $("#group_description").val(tempGroup.description);
            $("#group_member_list").empty();
            tempGroup.target.forEach(function(target) {
                $("#group_member_list").append(`
                    <div class="group-member flex items-center justify-between mb-4 shadow-md p-3 rounded-xl"
                        value="${target.id}" id="group_member_${target.id}">
                        <div class="flex flex-col gap-1">
                            <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">${target.first_name} ${target.last_name}</p>

                            <p class="text-xs font-medium text-gray-500 dark:text-gray-100">${target.department.name}</p>
                        </div>
                        <div>
                            <button type="button" data-value="${target.id}" onclick="removeUserFromGroup(${target.id})"
                                class="remove-user focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Remove</button>

                        </div>
                    </div>
                `);
            });
            setTargetSelection();
        }

        function setTargetSelection() {
            tempTargets = [];
            let strict = $("#strict_user_selected_department").is(":checked") ? 1 : 0;
            let department = $("#group_department").val();
            let groupMembers = [];
            if (strict == 1 && department) {
                tempTargets = targets.filter(target => target.department_id == department);
            } else {
                tempTargets = targets;
            }
            $(".group-member").each(function() {
                groupMembers.push($(this).attr("value"));
            });
            $("#group_member").empty();
            $("#group_member").append(
                `<option value="" selected>Select User</option>`);
            tempTargets.forEach(function(target) {
                $("#group_member").append(
                    `<option value="${target.id}">${target.first_name} ${target.last_name}</option>`);
            });
            $("#group_member option").each(function() {
                if (groupMembers.includes($(this).val())) {
                    $(this).remove();
                }
            });
        }

        function removeUserFromGroup(id) {
            $(`#group_member_${id}`).remove();
            setTargetSelection();
        }

        function addUserToGroup(id) {
            let tempUser = tempTargets.find(target => target.id == id);
            $("#group_member_list").append(`
                <div class="group-member flex items-center justify-between mb-4 shadow-md p-3 rounded-xl"
                    value="${tempUser.id}" id="group_member_${tempUser.id}">
                    <div class="flex flex-col gap-1">
                        <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">${tempUser.first_name} ${tempUser.last_name}</p>

                        <p class="text-xs font-medium text-gray-500 dark:text-gray-100">${tempUser.department.name}</p>
                    </div>
                    <div>
                        <button type="button" data-value="${tempUser.id}" onclick="removeUserFromGroup(${tempUser.id})"
                            class="remove-user focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Remove</button>

                    </div>
                </div>
            `);
            setTargetSelection();
        }

        function importTargetFromDepartment() {
            let department = $("#group_department").val();
            let tempMemberForImport = [];
            $(".group-member").each(function() {
                tempMemberForImport.push($(this).attr("value"));
            });
            if (department) {


                tempTargets = targets.filter(target => target.department_id == department);
                if (tempMemberForImport.length > 0) {
                    tempTargets = tempTargets.filter(target =>
                        !tempMemberForImport.map(Number).includes(target.id)
                    );
                }
                tempTargets.forEach(function(target) {
                    $("#group_member_list").append(`
                        <div class="group-member flex items-center justify-between mb-4 shadow-md p-3 rounded-xl"
                            value="${target.id}" id="group_member_${target.id}">
                            <div class="flex flex-col gap-1">
                                <p class="text-xs font-semibold text-gray-800 dark:text-gray-200">${target.first_name} ${target.last_name}</p>

                                <p class="text-xs font-medium text-gray-500 dark:text-gray-100">${target.department.name}</p>
                            </div>
                            <div>
                                <button type="button" data-value="${target.id}" onclick="removeUserFromGroup(${target.id})"
                                    class="remove-user focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Remove</button>

                            </div>
                        </div>
                `);
                });

                setTargetSelection();
            } else {
                $("#import_user_selected_department").prop('checked', false);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select department!',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Close'

                });
                return;
            }
        }

        function createGroup() {
            let name = $("#group_name").val();
            let department = $("#group_department").val();
            let status = $("#group_status").val();
            let description = $("#group_description").val();
            let members = [];
            $(".group-member").each(function() {
                members.push($(this).attr("value"));
            });
            $.ajax({
                url: "{{ route('createGroup') }}",
                type: 'POST',
                data: {
                    name: name,
                    department: department,
                    status: status,
                    members: members,
                    description: description,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Close'
                    });
                    hideModal('add-group-modal');
                    $("#error_message_field").hide();
                    getGroups();
                },
                error: function(xhr) {
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
                }
            });
        }

        function updateGroup(id){
            let name = $("#group_name").val();
            let department = $("#group_department").val();
            let status = $("#group_status").val();
            let description = $("#group_description").val();
            let members = [];
            $(".group-member").each(function() {
                members.push($(this).attr("value"));
            });
            $.ajax({
                url: "{{ route('updateGroup') }}",
                type: 'POST',
                data: {
                    id: id,
                    name: name,
                    department: department,
                    status: status,
                    members: members,
                    description: description,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Close'
                    });
                    hideModal('add-group-modal');
                    $("#error_message_field").hide();
                    getGroups();
                },
                error: function(xhr) {
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
                }
            });
        }

        function showDeleteGroupModal(id){
            tempGroup = groups.find(group => group.id == id);
            Swal.fire({
                title: 'Are you sure?',
                text: `You want to delete ${tempGroup.name} group!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                cancelButtonColor: '#3b82f6',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteGroup') }}",
                        type: 'POST',
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close'
                            });
                            getGroups();
                        },
                        error: function(xhr) {
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
                        }
                    });
                }
            });
        }

        function showDetailsGroupModal(id){
            tempGroup = groups.find(group => group.id == id);
            console.log(tempGroup);
            showModal('details-group-modal');
            $("#group_name_details").text(tempGroup.name);
            $("#group_status_details").text(tempGroup.status == 1 ? 'Active' : 'Inactive');
            $("#group_created_at_details").text(new Date(tempGroup.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }));
            $("#group_updated_at_details").text(new Date(tempGroup.updated_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }));
            $("#group_department_details").text(tempGroup.department.name);
            $("#group_member_count_details").text(tempGroup.target_count);
            $("#group_description_details").text(tempGroup.description);
            $("#list-targets-groups-tbody").empty();
            tempGroup.target.forEach(function(target){
                $("#list-targets-groups-tbody").append(`
                    <tr class="text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-700">
                        <td class="p-4">${target.first_name} ${target.last_name}</td>
                        <td class="p-4">${target.position.name}</td>
                        <td class="p-4">${target.department.name}</td>
                        <td class="p-4">${target.email}</td>
                    </tr>
                `);
            });
        }
    </script>



@endSection
