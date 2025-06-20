@extends('layouts.master')
@section('title', 'Fischsim - Admin Companies')
@section('content')
    @include('contents.modal.admin.update-company-admin')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Company List</h1>
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="status"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Visibility</label>
                        <select id="status_filter" name="status" onchange="getAllCompanies()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All</option>
                            <option value="1">Public</option>
                            <option value="2">Private</option>
                        </select>
                    </div>
                    <div>
                        <label for="active"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select id="status_active" name="active" onchange="getAllCompanies()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">All</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                    <div class="flex md:flex-row flex-col items-start md:items-center mb-4 md:mb-0">
                        <label for="show" class="mr-2 text-xs md:text-sm font-medium mb-2 md:mb-0">Show</label>
                        <select id="show" name="show" onchange="getAllCompanies()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getAllCompanies()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class="min-w-32 overflow-x-auto md:min-w-full">
                    <table class="min-w-32 md:min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                <th scope="col" class="p-4">Company Name</th>
                                <th scope="col" class="p-4">Visibility</th>
                                <th scope="col" class="p-4">Email</th>
                                <th scope="col" class="p-4">Max Account</th>
                                <th scope="col" class="p-4">User</th>
                                <th scope="col" class="p-4">Owner</th>
                                <th scope="col" class="p-4">Owner Email</th>
                                <th scope="col" class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody id="list-admin-company-tbody"
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
                    <ul id="page-button-admin-company"
                        class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        let companies = [];
        $(document).ready(function() {
            getAllCompanies();
        });

        function getAllCompanies(page = 1) {
            let status = $("#status_filter").val();
            let show = $("#show").val();
            let search = $("#search").val();
            let active = $("#status_active").val();
            $.ajax({
                url: "{{ route('getAllCompany') }}",
                type: "GET",
                data: {
                    status: status,
                    show: show,
                    search: search,
                    active: active,
                    page: page
                },
                success: function(data) {
                    companies = data.companies;
                    // console.log(data);
                    $("#list-admin-company-tbody").empty();
                    companies.forEach(function(company) {
                        let available = "";
                        if ((company.max_account - company.total_user) == 0) {

                            available = `<div class="bg-orange-100 text-orange-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300 inline-block">Full
                                            </div>`;
                        } else if (company.total_user == 0) {
                            available = `<div class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300 inline-block"  style="white-space: nowrap;">No Account
                                            </div>`;
                        } else if (company.total_user < company.max_account) {
                            available = `<div class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 inline-block">Available (${company.max_account - company.total_user})
                                            </div>`;
                        }
                        let visibility = company.visibility_id === 1 ? `<div class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">Public
                                            </div>` : `<div class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 inline-block">Private
                                            </div>`;
                        let status = company.status_id == 1 ? `<div class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">Active
                                            </div>` : `<div class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 inline-block">Inactive
                                            </div>`;
                        let owner = company.user ? company.user.first_name + " " + company.user
                            .last_name : "N/A";
                        let row = `<tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4">${company.name}</td>
                                <td class="p-4">${visibility}</td>
                                <td class="p-4">${company.email}</td>
                                <td class="p-4">${company.max_account}</td>
                                <td class="p-4">${available}</td>
                                <td class="p-4">${owner}</td>
                                <td class="p-4">${company.user ? company.user.email : "N/A"}</td>
                                <td class="p-4 flex gap-2">
                                    <button onclick="showEditCompanyModal(${company.id})"
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Update</button>
                                    <button onclick="deleteCompany(${company.id})"
                                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Remove</button>
                                </td>
                            </tr>`;
                        $("#list-admin-company-tbody").append(row);
                    });
                    paginationCompanyAdminList('#page-button-admin-company', data.pageCount, data.currentPage);
                    $("#numberFirstItem").text(
                        data.companyTotal != 0 ? (page - 1) * $("#show").val() + 1 : 0
                    );
                    $("#numberLastItem").text(
                        (page - 1) * $("#show").val() + data.companies.length
                    );
                    $("#totalCompanyCount").text(data.companyTotal);



                }
            });
        };

        async function showEditCompanyModal(id) {
            showModal('update-company-admin');
            await getUserIdbyCompany(id);
            let company = companies.find(company => company.id == id);
            $("#company_name").val(company.name);
            $("#company_email").val(company.email);
            $("#max_account").val(company.max_account);
            $("#visibility").prop('checked', company.visibility_id === 1 ? true : false);
            $("#status").prop('checked', company.status_id === 1 ? true : false);
            $("#button-for-target").attr('onclick', `editCompany(${id})`);
            $("#button-for-target").text('Update');
            $("#owner").val(company.user ? company.user.id : "");
        }

        function editCompany(id) {
            let name = $("#company_name").val();
            let email = $("#company_email").val();
            let max_account = $("#max_account").val();
            let visibility = $("#visibility").is(":checked") ? 1 : 0;
            let owner = $("#owner").val();
            let status = $("#status").is(":checked") ? 1 : 0;

            $.ajax({
                url: "{{ route('editCompany') }}",
                type: "POST",
                data: {
                    id: id,
                    name: name,
                    email: email,
                    max_account: max_account,
                    visibility: visibility,
                    owner: owner,
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.status == 'success') {
                        getAllCompanies();
                        hideModal('update-company-admin');
                        Swal.fire({
                            title: 'Success',
                            text: 'Successfully updated company.',
                            icon: 'success',
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700',

                            }
                        });
                    }
                }
            });
        }

        function deleteCompany(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#26d43b',
                reverseButtons: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'No, cancel!',
                customClass: {
                    confirmButton: 'bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-2',
                    cancelButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteCompany') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                getAllCompanies();
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Success deleted company.',
                                    icon: 'success',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                }
            });
        }

        async function getUserIdbyCompany(id) {

            await $.ajax({
                url: "{{ route('getUsersByCompanyId', '') }}/" + id,
                type: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    // console.log(data);
                    $('#owner').empty();
                    $('#owner').append(`<option value="" disabled>Select Owner</option>`);
                    data.users.forEach(function(user) {
                        $('#owner').append(
                            `<option value="${user.id}">${user.first_name} ${user.last_name}</option>`
                        );
                    });
                }
            });
        }
    </script>
@endsection
