@extends('layouts.master')
@section('title', 'Fischsim - Admin Users')
@section('content')
    @include('contents.modal.admin.update-user-admin')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">User List</h1>
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="status"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status" name="status" onchange="getAllUser()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All</option>
                            <option value="1">Verified</option>
                            <option value="0">Unverified</option>
                        </select>
                    </div>
                </div>
                @IsAdmin()
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="companyCheckAdmin"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                        <select id="companyCheckAdmin" name="companyCheckAdmin" onchange="getAllUser()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endIsAdmin()
                </div>
                <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                    <div class="flex md:flex-row flex-col items-start md:items-center mb-4 md:mb-0">
                        <label for="show" class="mr-2 text-xs md:text-sm font-medium mb-2 md:mb-0">Show</label>
                        <select id="show" name="show" onchange="getAllUser()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getAllUser()"
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
                                <th scope="col" class="p-4">Email</th>
                                <th scope="col" class="p-4">Company</th>
                                <th scope="col" class="p-4">Verify</th>
                                <th scope="col" class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody id="list-admin-user-tbody"
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
                    <ul id="page-button-admin-user"
                        class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                    </ul>
                </nav>
            </div>
        </div>

        <script>
            let users = [];
            $(document).ready(function() {
                getAllUser();
            });

            function getAllUser(page = 1) {
                let status = $("#status").val();
                let company = $("#companyCheckAdmin").val();
                let show = $("#show").val();
                let search = $("#search").val();
                $.ajax({
                    url: "{{ route('getAllUser') }}",
                    type: "GET",
                    data: {
                        status: status,
                        company: company,
                        show: show,
                        search: search,
                        page: page
                    },
                    success: function(data) {
                        users = data.users;
                        $("#list-admin-user-tbody").empty();
                        let verified = '';
                        users.forEach(function(user) {
                            if (user.email_verified_at != null) {
                                verified = `<div class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">
                                                Verified
                                            </div>`;
                            } else {
                                verified = `<div class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 inline-block">
                                                Unverified
                                            </div>`;
                            }

                            let tr = `<tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4">${user.first_name}</td>
                                <td class="p-4">${user.last_name}</td>
                                <td class="p-4">${user.email}</td>
                                <td class="p-4">${user.company.name}</td>
                                <td class="p-4">${verified}</td>
                                <td class="p-4 flex gap-2">
                                    <button onclick="showEditUserModal(${user.id})"
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Edit</button>
                                      <button onclick="deleteUser(${user.id})"
                                    class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Remove</button>
                                </td>
                            </tr>`;
                            $("#list-admin-user-tbody").append(tr);
                        });
                        $("#numberFirstItem").text(
                            data.userTotal != 0 ? (page - 1) * $("#show").val() + 1 : 0
                        );
                        $("#numberLastItem").text(
                            (page - 1) * $("#show").val() + data.users.length
                        );
                        $("#totalTemplatesCount").text(data.userTotal);
                        paginationUserAdminList("#page-button-admin-user", data.pageCount, data.currentPage);

                    }
                });
            };

            function showEditUserModal(id) {
                showModal('update-user-admin');
                let user = users.find(user => user.id == id);
                $("#first_name").val(user.first_name);
                $("#last_name").val(user.last_name);
                $("#email_user").val(user.email);
                $("#phone_user").val(user.phone);
                $("#button-for-target").attr('onclick', `editUser(${id})`);
                user.email_verified_at != null ? $("#verified-user").prop('checked', true) : $(
                    "#verified-user").prop('checked', false);

            }

            function editUser(id) {
                let first_name = $("#first_name").val();
                let last_name = $("#last_name").val();
                let email = $("#email_user").val();
                let phone = $("#phone_user").val();
                let verified = $("#verified-user").is(":checked") ? 1 : 0;
                $.ajax({
                    url: "{{ route('editUser') }}",
                    type: "POST",
                    data: {
                        id: id,
                        first_name: first_name,
                        last_name: last_name,
                        email: email,
                        phone: phone,
                        verified: verified,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            getAllUser();
                            hideModal('update-user-admin');
                            Swal.fire({
                                title: 'Success',
                                text: 'Success updated user.',
                                icon: 'success',
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'OK',
                                customClass: {
                                    confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700'

                                },
                            });
                        }
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
                        }
                    }
                });
            }

            function deleteUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d97706',
                    cancelButtonColor: '#e3342f',
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700',
                        cancelButton: 'bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-2'
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('deleteUser') }}",
                            type: "POST",
                            data: {
                                id: id,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                if (data.status == 'success') {
                                    getAllUser();
                                    Swal.fire({
                                        title: 'Success',
                                        text: 'Success deleted user.',
                                        icon: 'success',
                                        confirmButtonColor: '#10b981',
                                        confirmButtonText: 'OK',
                                        customClass: {
                                            confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700',

                                        },
                                    });
                                }
                            }
                        });
                    }
                });
            }
        </script>
    @endsection
