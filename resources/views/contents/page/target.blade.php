@extends('layouts.master')
@section('title', 'Fischsim - Target')
@section('content')
    @include('contents.modal.target.import-target-modal')
    @include('contents.modal.target.add-target-modal')
    @include('contents.modal.target.preview-import-target-modal')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="md:text-3xl text-xl font-semibold">Company Target</h1>
                @CanCreateTarget()
                <div class="flex items-center justify-center flex-row gap-2">
                    @IsUser()
                    <button onclick="showImportTargetModal()"
                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 flex items-center"
                        title="Import Target">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 md:hidden">
                            <path fill-rule="evenodd"
                                d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="hidden md:inline">Import Target</span>
                    </button>
                    @endIsUser()

                    <button onclick="showAddTargetModal()"
                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center"
                        title="Create Target">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 md:hidden">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="hidden md:inline">Create Target</span>
                    </button>

                </div>
                @endCanCreateTarget()
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="md:max-w-xs max-w-full">
                    <div>
                        <label for="position" class="mb-1 block text-xs md:text-sm font-medium">Position</label>
                        <select id="position" name="position" onchange="getTargets()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        </select>
                    </div>
                    <div>
                        <label for="department"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                        <select id="department" name="department" onchange="getTargets()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                        </select>
                    </div>
                    @IsAdmin()
                    <div class="md:max-w-xs max-w-full">
                        <div>
                            <label for="companyCheckAdmin"
                                class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                            <select id="companyCheckAdmin" name="companyCheckAdmin" onchange="getTargets()"
                                class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">All</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endIsAdmin()
                </div>
                <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                    <div class="flex md:flex-row flex-col items-start md:items-center mb-4 md:mb-0">
                        <label for="show" class="mr-2 text-xs md:text-sm font-medium mb-2 md:mb-0">Show</label>
                        <select id="show" name="show" onchange="getTargets()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getTargets()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class="min-w-32 overflow-x-auto md:min-w-full">
                    <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                <th scope="col" class="p-4">First Name</th>
                                <th scope="col" class="p-4">Last Name</th>
                                <th scope="col" class="p-4">Position</th>
                                <th scope="col" class="p-4">Department</th>
                                <th scope="col" class="p-4">Email</th>
                                @CanModifyTarget()
                                <th scope="col" class="p-4">Action</th>
                                @endCanModifyTarget()
                            </tr>
                        </thead>
                        <tbody id="list-targets-tbody"
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
                    <ul id="page-button-target-company"
                        class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                    </ul>
                </nav>
            </div>
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
            let company = $('#companyCheckAdmin').val();
            $.ajax({
                url: "{{ route('getTargets') }}" + '?page=' + page,
                type: 'GET',
                data: {
                    department: department,
                    position: position,
                    show: show,
                    search: search,
                    companyId: company
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
            if (targets.length == 0) {
                $("#list-targets-tbody").append(`
                  <tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                            <td class="p-4" colspan="6">No data available</td>
                        </tr>
                `);
            } else {
                targets.forEach(function(target, index) {
                    // <div class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">
                    //                             True
                    //                         </div>
                    let color = ''
                    switch (target.department_id) {
                        case 1:
                            color = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                            break;
                        case 2:
                            color = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                            break;
                        case 3:
                            color = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                            break;
                        case 4:
                            color = 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300';
                            break;
                        case 5:
                            color = 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300';
                            break;
                        case 6:
                            color = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                            break;
                        case 7:
                            color = 'bg-teal-100 text-teal-800 dark:bg-teal-900 dark:text-teal-300';
                            break;
                        case 8:
                            color = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300';
                            break;
                        case 9:
                            color = 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300';
                            break;
                        case 10:
                            color = 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300';
                            break;
                        case 11:
                            color = 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-300';
                            break;
                        case 12:
                            color = 'bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-900 dark:text-fuchsia-300';
                            break;
                        default:
                            color = 'pink';
                            break;
                    }
                    let department = `<div class="${color} text-xs font-medium me-2 px-2.5 py-0.5 rounded inline-block">
                                                ${target.department.name}
                                            </div>`;
                    $("#list-targets-tbody").append(`
                    <tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                        <td class="p-4">${target.first_name}</td>
                        <td class="p-4">${target.last_name}</td>
                        <td class="p-4">${target.position.name}</td>
                        <td class="p-4">${department}</td>
                        <td class="p-4">${target.email}</td>
                        @CanModifyTarget()
                        <td class="p-4 flex gap-2">
                            @CanUpdateTarget()
                            <button onclick="showUpdateTargetModal(${target.id}, '${target.first_name}', '${target.last_name}','${target.email}', '${target.position.id}', '${target.department.id}')"
                                class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Update</button>
                            @endCanUpdateTarget()
                            @CanDeleteTarget()
                            <button onclick="deleteTarget(${target.id})"
                                class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Delete</>
                            @endCanDeleteTarget()
                                </td>
                        @endCanModifyTarget()

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
            $("#target_first_name").val('');
            $("#target_last_name").val('');
            $("#target_email").val('');
            $("#target_department").val('');
            $("#target_position").val('');
            $("#title-add-target-modal").text('Add Target');
            $("#button-for-target").removeAttr('onclick').attr('onclick', 'createTarget()');
            $("#button-for-target").text('Add');
            $("#admin_company_input_div").show();
            $("#error_message_field").hide();
            showModal('add-target-modal');
        }

        function showUpdateTargetModal(id, firstName, lastName, email, position, department) {
            $("#target_first_name").val(firstName);
            $("#target_last_name").val(lastName);
            $("#target_email").val(email);
            $("#target_department").val(department);
            $("#target_position").val(position);
            $("#title-add-target-modal").text('Update Target');
            $("#button-for-target").removeAttr('onclick').attr('onclick', `updateTarget(${id})`);
            $("#button-for-target").text('Update');
            $("#admin_company_input_div").hide();
            $("#error_message_field").hide();
            showModal('add-target-modal');

        }

        function createTarget() {
            preventDoubleClick('button-for-target', true);
            let firstName = $('#target_first_name').val();
            let lastName = $('#target_last_name').val();
            let email = $('#target_email').val();
            let position = $('#target_position').val();
            let department = $('#target_department').val();
            let company = $('#admin_company_input').val() == '' ? '' : $('#admin_company_input').val();

            $.ajax({
                url: "{{ route('createTarget') }}",
                type: 'POST',
                data: {
                    first_name: firstName,
                    last_name: lastName,
                    email: email,
                    position: position,
                    department: department,
                    _token: "{{ csrf_token() }}",
                    company: company
                },
                success: function(response) {
                    preventDoubleClick('button-for-target', false);
                    $("#button-for-target").prop('disabled', false);
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
                    preventDoubleClick('button-for-target', false);
                    var errorMessage = JSON.parse(xhr.responseText) ? JSON.parse(xhr.responseText) : xhr
                        .responseText;
                    var errors = errorMessage.message ? errorMessage.message : errorMessage;
                    $('#error_message_field').show();
                    $('#error_message').empty();
                    $('#error_message').append(`<li>${errors}</li>`);


                }
            });
        }

        function updateTarget(id) {
            preventDoubleClick('button-for-target', true);
            let firstName = $('#target_first_name').val();
            let lastName = $('#target_last_name').val();
            let email = $('#target_email').val();
            let position = $('#target_position').val();
            let department = $('#target_department').val();

            $.ajax({
                url: "{{ route('updateTarget') }}",
                type: 'POST',
                data: {
                    id: id,
                    first_name: firstName,
                    last_name: lastName,
                    email: email,
                    position: position,
                    department: department,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    preventDoubleClick('button-for-target', false);
                    $("#button-for-target").prop('disabled', false);
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
                    preventDoubleClick('button-for-target', false);
                    var errorMessage = JSON.parse(xhr.responseText) ? JSON.parse(xhr.responseText) : xhr
                        .responseText;
                    var errors = errorMessage.message ? errorMessage.message : errorMessage;
                    $('#error_message_field').show();
                    $('#error_message').empty();
                    $('#error_message').append(`<li>${errors}</li>`);
                }
            });
        }

        function deleteTarget(id) {
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
                        url: "{{ route('deleteTarget') }}",
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
                            getTargets();
                        },
                        error: function(xhr) {
                            swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: xhr.responseJSON.message,
                                confirmButtonColor: '#ef4444',
                                confirmButtonText: 'Close'
                            });
                        }
                    });
                }
            });
        }

        function showImportTargetModal() {
            showModal('import-target-modal');
        }

        function previewImportTarget() {
            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('target', $('#targetFile').prop('files')[0]);
            formData.append('separator', $('#separator').val());
            $.ajax({
                url: "{{ route('previewImportTarget') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    hideModal('import-target-modal');
                    showModal('preview-import-target-modal');
                    $("#target-preview-body").empty();
                    Object.keys(response.targets).forEach(function(key) {
                        let target = response.targets[key];
                        $("#target-preview-body").append(`
                        <tr class=text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                            <td class="p-4">${target.first_name}</td>
                            <td class="p-4">${target.last_name}</td>
                            <td class="p-4">${target.email}</td>
                            <td class="p-4">${target.position}</td>
                            <td class="p-4">${target.department}</td>
                        </tr>
                        `);
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status == 403 || xhr.status == 400) {
                        var errorMessage = JSON.parse(xhr.responseText) ? JSON.parse(xhr.responseText) : xhr
                            .responseText;
                        console.log(errorMessage);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: errorMessage.errors[0],
                            confirmButtonColor: '#ef4444',
                            confirmButtonText: 'Close'

                        })
                    } else {
                        let errorMessage = JSON.parse(xhr.responseText);
                        swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: errorMessage.message,
                            confirmButtonColor: '#ef4444',
                            confirmButtonText: 'Close'
                        })
                    }
                }
            });
        }

        function importTarget() {
            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('target', $('#targetFile').prop('files')[0]);
            formData.append('separator', $('#separator').val());
            $.ajax({
                url: "{{ route('importTarget') }}",
                type: "POST",
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
                    });
                    hideModal('preview-import-target-modal');
                    getTargets();
                },
                error: function(xhr, status, error) {
                    let errorMessage = JSON.parse(xhr.responseText);
                    swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorMessage.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Close'
                    });
                }
            });
        }
    </script>
@endSection
