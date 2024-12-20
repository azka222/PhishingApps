@extends('layouts.master')
@section('title', 'Target')
@section('content')
    @include('contents.modal.add-target-modal')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Company Target</h1>
                <div>
                    <button
                        class="px-4 py-2 me-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Import
                        Target</button>
                    <button onclick="showAddTargetModal()"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Add
                        Target</button>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-xs">
                    <div>
                        <label for="position" class="mb-1 block text-sm font-medium">Position</label>
                        <select id="position" name="position" onchange="getTargets()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        </select>
                    </div>
                    <div>
                        <label for="department" onchange="getTargets()"
                            class="mb-1 mt-4 block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                        <select id="department" name="department"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        </select>
                    </div>
                </div>
            </div>
            <div class="flex p-4 justify-between items-center mt-8">
                <div class="flex items-center">
                    <label for="show" class="mr-2 text-sm font-medium">Show</label>
                    <select id="show" name="show" onchange="getTargets()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div class="flex items-center">
                    <input type="text" id="search" name="search" onchange="getTargets()"
                        class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search...">
                </div>
            </div>

            <table class="p-4 min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                <thead class="bg-gray-300 dark:bg-gray-700">
                    <tr
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                        <th scope="col" class="p-4">Name</th>
                        <th scope="col" class="p-4">Position</th>
                        <th scope="col" class="p-4">Department</th>
                        <th scope="col" class="p-4">Email</th>
                        <th scope="col" class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                </tbody>
            </table>
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4"
                aria-label="Table navigation">
                <span
                    class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing
                    <span class="font-semibold text-gray-900 dark:text-white"> <span id="numberFirstItem">1</span> - <span
                            id="numberLastItem">4</span></span> of
                    <span id="totalTemplatesCount" class="font-semibold text-gray-900 dark:text-white">4</span>
                </span>
                <ul id="page-button-target-company" class="inline-flex space-x-2 rtl:space-x-reverse text-sm h-8">

                </ul>
            </nav>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            getTargetResources();
            getTargets();
        });


        function getTargetResources() {
            $.ajax({
                url: "{{ route('getTargetResources') }}",
                type: 'GET',
                success: function(response) {
                    let department = response.department;
                    let position = response.position;
                    setFilter(department, position);
                    setSelectForModal(position, department);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function getTargets(page = 1) {
            let department = $('#department').val() ? $('#department').val() : '';
            let position = $('#position').val() ? $('#position').val() : '';
            let show = $('#show').val() ? $('#show').val() : '';
            let search = $('#search').val() ? $('#search').val() : '';
            $.ajax({
                url: "{{ route('getTargets') }}" + '?page=' + page,
                type: 'GET',
                data: {
                    department: department,
                    position: position,
                    show: show,
                    search: search
                },
                success: function(response) {
                    let targets = response.targets;
                    setTargets(targets, response.pageCount, response.currentPage);
                    $("#numberFirstItem").text(
                        response.targetTotal != 0 ? (page - 1) * $("#show").val() + 1 : 0
                    );
                    $("#numberLastItem").text(
                        (page - 1) * $("#show").val() + response.targets.length
                    );
                    $("#totalTemplatesCount").text(response.targetTotal);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function setTargets(targets, count, current) {
            let table = $('tbody');
            table.empty();
            if (!targets) {
                table.append(`
                <tr class="bg-white dark:bg-gray-800">
                    <td class="p-4 text-center" colspan="5">No data available</td>
                </tr>
                `);
            } else {
                targets.forEach(function(target, index) {
                    table.append(`
                    <tr class="text-sm font-normal text-gray-900 dark:text-gray-400 bg-white dark:bg-gray-800 border-b-2 border-gray-600">
                        <td class="p-4">${target.name}</td>
                        <td class="p-4">${target.position.name}</td>
                        <td class="p-4">${target.department.name}</td>
                        <td class="p-4">${target.email}</td>
                        <td class="p-4 flex gap-2">
                            <button onclick="updateTarget(${target.id})"
                                class="py-2 px-2 text-xs font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Update</button>
                            <button onclick="deleteTarget(${target.id})"
                                class="py-2 px-2 text-xs font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Delete</button>
                        </td>

                    </tr>
                    `);
                });
                paginationTargetCompany("#page-button-target-company", count, current)

            }
        }

        function setFilter(department, position) {
            let departmentSelect = $('#department');
            let positionSelect = $('#position');
            departmentSelect.empty();
            positionSelect.empty();
            departmentSelect.append('<option value="">Select Department</option>');
            positionSelect.append('<option value="">Select Position</option>');
            department.forEach(function(department) {
                departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
            });

            position.forEach(function(position) {
                positionSelect.append('<option value="' + position.id + '">' + position.name + '</option>');
            });
        }

        function setSelectForModal(position, department) {
            let departmentSelect = $('#target_department');
            let positionSelect = $('#target_position');
            departmentSelect.empty();
            positionSelect.empty();
            departmentSelect.append('<option value="">Select Department</option>');
            positionSelect.append('<option value="">Select Position</option>');
            department.forEach(function(department) {
                departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
            });

            position.forEach(function(position) {
                positionSelect.append('<option value="' + position.id + '">' + position.name + '</option>');
            });
        }

        function showAddTargetModal() {
            $("#target_name").val('');
            $("#target_email").val('');
            $("#target_department").val('');
            $("#target_position").val('');
            showModal('add-target-modal');
        }

        function createTarget() {
            let name = $('#target_name').val();
            let email = $('#target_email').val();
            let position = $('#target_position').val();
            let department = $('#target_department').val();

            $.ajax({
                url: "{{ route('createTarget') }}",
                type: 'POST',
                data: {
                    name: name,
                    email: email,
                    position: position,
                    department: department,
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
                    $("#error_message_field").hide();
                    hideModal('add-target-modal');
                    getTargets();
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
    </script>
@endSection
