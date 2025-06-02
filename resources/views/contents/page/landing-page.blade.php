@extends('layouts.master')
@section('title', 'Fischsim - Landing Page')
@section('content')
    @include('contents.modal.landing-page.add-landing-page-modal')
    @include('contents.modal.landing-page.import-site-modal')
    <div class=" p-4 w-full flex flex-col h-full min-h-screen  bg-gray-50 dark:bg-gray-800 dark:text-white text-gray-900">
        <div class="">
            <div class="flex p-4 items-center justify-between">
                <h1 class="text-3xl font-semibold">Landing Page Templates</h1>
                @CanCreateLandingPage()
                <div>
                    <button onclick="showAddLandingPageModal()"
                        class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 md:hidden">
                            <path fill-rule="evenodd"
                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="hidden md:inline">Create Page</span>
                    </button>
                </div>
                @endCanCreateLandingPage()
            </div>
            <div class="flex flex-col gap-4 p-4">
                <div class="max-w-full md:max-w-xs">
                    <div>
                        <label for="capture_passwords" class="mb-1 block text-xs md:text-sm font-medium">Capture
                            Password</label>
                        <select id="capture_passwords" name="capture_passwords" onchange="getLandingPage()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="2">All</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>

                        </select>
                    </div>
                    <div>
                        <label for="capture_credentials"
                            class="mb-1 mt-4 block text-xs md:text-sm font-medium text-gray-700 dark:text-gray-300">Capture
                            Credentials</label>
                        <select id="capture_credentials" name="capture_credentials" onchange="getLandingPage()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="2">All</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="flex md:flex-row flex-col justify-between items-start md:items-center mt-8">
                    <div class="flex md:flex-row flex-col items-start md:items-center mb-4 md:mb-0">
                        <label for="show" class="mr-2 text-xs md:text-sm font-medium mb-2 md:mb-0">Show</label>
                        <select id="show" name="show" onchange="getLandingPage()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <input type="text" id="search" name="search" onchange="getLandingPage()"
                            class="bg-gray-100 border border-gray-300 text-gray-900 text-xs md:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5 w-64 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search...">
                    </div>
                </div>
                <div class=" min-w-38 overflow-x-auto md:min-w-full">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-4">
                        <thead class="bg-gray-300 dark:bg-gray-700">
                            <tr
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                                <th scope="col" class="p-4">Name</th>
                                <th scope="col" class="p-4">Capture Credentials</th>
                                <th scope="col" class="p-4">Capture Password</th>
                                <th scope="col" class="p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody id="list-page-tbody"
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
                    <ul id="pagination-page-button"
                        class="inline-flex space-x-2 rtl:space-x-reverse text-xs md:text-sm h-8">

                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script>
        let landingPages = [];
        $(document).ready(function() {
            getLandingPage();
        });

        function getLandingPage(page = 1) {
            let show = $("#show").val();
            let search = $("#search").val();
            let capture_credentials = $("#capture_credentials").val();
            let capture_passwords = $("#capture_passwords").val();
            let companyId = $("#companyCheckAdmin").val();
            $.ajax({
                url: "{{ route('getLandingPage') }}" + "?page=" + page,
                type: "GET",
                data: {
                    show: show,
                    search: search,
                    page: page,
                    capture_credentials: capture_credentials,
                    capture_passwords: capture_passwords,
                    companyId: companyId
                },
                success: function(response) {
                    // console.log(response);
                    $("#list-page-tbody").empty();
                    $("#pagination-page-button").empty();
                    landingPages = response.landingPage; // landingPage == data
                    // console.log(landingPages.length);
                    if (landingPages.length == 0) {
                        let data = `<tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4" colspan="4">No data available</td>
                            </tr>`;
                        $("#list-page-tbody").append(data);
                    }

                    Object.keys(landingPages).forEach(function(key) {
                        let value = landingPages[key];
                        let credentials = '';
                        let password = '';
                        if (value.capture_credentials != 0) {
                            credentials = `<div class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">
                                                True
                                            </div>`;
                        } else {
                            credentials = `<div class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 inline-block">
                                                False
                                            </div>`;
                        }
                        if (value.capture_passwords != 0) {
                            password = `<div class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 inline-block">
                                                True
                                            </div>`;
                        } else {
                            password = `<div class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300 inline-block">
                                                False
                                            </div>`;
                        }
                        $("#list-page-tbody").append(`
                            <tr class="text-xs md:text-sm font-light text-gray-600 dark:text-gray-400 bg-white dark:bg-gray-800">
                                <td class="p-4 whitespace-nowrap">${value.name}</td>
                                <td class="p-4">${credentials}</td>
                                <td class="p-4">${password}</td>
                                <td class="p-4 flex gap-2">
                                    <button onclick="showLandingPage(${value.id})" class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">Preview</button>
                                    @CanModifyLandingPage()
                                        @CanUpdateLandingPage()
                                            <button onclick="showModalEditLandingPage(${value.id})" class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">Update</button>
                                        @endCanUpdateLandingPage()
                                        @CanDeleteLandingPage()
                                            <button onclick="deleteLandingPage(${value.id})" class="px-4 py-2 text-xs md:text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Delete</button>
                                        @endCanDeleteLandingPage()
                                    @endCanModifyLandingPage()
                                </td>
                            </tr>
                        `);


                    });
                    paginationLandingPage("#pagination-page-button", response.pageCount, response.currentPage);
                    $("#numberFirstItem").text(
                        response.targetTotal != 0 ? (page - 1) * $("#show").val() + 1 : 0
                    );
                    $("#numberLastItem").text(
                        (page - 1) * $("#show").val() + response.landingPage.length
                    );
                    $("#totalTemplatesCount").text(response.targetTotal);

                }
            });
        }

        function showAddLandingPageModal() {
            showModal('add-landing-page-modal');
            $("#admin_company_input_div").show();
            $("#title-add-landing-page-modal").text('Create Landing Page');
            $("#button-for-pages").text('Create');
            $("#button-for-pages").removeAttr('onclick').attr('onclick',
                `createLandingPage()`);
            $("#landing_name").val('');
            $("#content").val('');
            $("#submitted-checkbox").prop("checked", false);
            $("#passwords-checkbox").prop("checked", false);
            $("#redirect_url").val('');
            $("#error_message_field").hide();
            $("#error_http_header").hide();
            $("#error_message").empty();
            // await fetchWebsiteUrl(); // Call the async function
        }

        function handleCheckboxAndUrl() {
            $("#submitted-checkbox").change(function() {
                if (!$(this).is(":checked")) {
                    $("#passwords-checkbox").prop("checked", false);
                    $("#redirect_url").val('');
                }
            });
        }

        $(document).ready(function() {
            handleCheckboxAndUrl();
        });

        function showLandingPage(id) {
            window.open("{{ route('landingPagePreview', ['id' => '__ID__']) }}".replace('__ID__', id));
        }

        function showImportUrl() {
            showModal('import-site-modal');
        }



        async function fetchWebsiteUrl() {
            let url = $("#url_website").val(); // Get URL input value
            if (url === "") {
                $("#error-http-header").show(); // Show error if URL is empty
            }
            if (url !== "") {
                $("#error-http-header").hide(); // Hide error
            }

            try {
                // Show loading indicator
                Swal.fire({
                    title: "Loading...",
                    text: "Fetching website HTML...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                // Perform the AJAX request
                const response = await $.ajax({
                    url: "{{ route('fetchWebsiteUrl') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        url: url,
                    },
                });

                // Handle success
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.message,
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Close',
                    customClass: {
                        confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                    }
                });
                if (response.html) {
                    let response_html = response.html;
                    $("#content").empty(); // Clear the editor content
                    $("#content").val(response_html); // Set the editor content
                    hideModal('import-site-modal'); // Hide the modal
                } else {
                    // console.log("HTML not found!");
                }
            } catch (error) {
                // Handle errors
                let errorMessage = error.responseJSON?.message || "An error occurred!";
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: errorMessage,
                    confirmButtonColor: '#10b981',
                    confirmButtonText: 'Close',
                    customClass: {
                        confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                    }
                });
            }
        }

        function showWarning() {
            if ($("#submitted-checkbox").is(":checked")) {
                $(".hidden-capture").show();
            } else {
                $(".hidden-capture").hide();
            }
        }

        function createLandingPage() {
            let name = $("#landing_name").val();
            let submitted = $("#submitted-checkbox").is(":checked") ? 1 : 0;
            let passwords = $("#passwords-checkbox").is(":checked") ? 1 : 0;
            let redirect_url = $("#redirect_url").val();
            let content = $("#content").val();
            let company = $("#admin_company_input").val() ? $("#admin_company_input").val() : '';
            // console.log(content);
            let error_message = [];
            if (name === "") {
                error_message.push("Name is required");
            }
            if (content === "") {
                error_message.push("Content is required");
            }
            // console.log(submitted);
            // console.log(passwords);
            if (error_message.length > 0) {
                $("#error_message_field").show();
                $("#error_message").empty();
                error_message.forEach(function(value) {
                    $("#error_message").append(`<li>${value}</li>`);
                });
            } else {
                $("#error_message_field").hide();
                $.ajax({
                    url: "{{ route('createLandingPage') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        landing_name: name,
                        html_content: content,
                        capture_credentials: submitted,
                        capture_passwords: passwords,
                        redirect_url: redirect_url,
                        company: company
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: response.message,
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close',
                                customClass: {
                                    confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                                },
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    hideModal('add-landing-page-modal')
                                }
                            });
                            getLandingPage();

                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: response.message,
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close',
                                customClass: {
                                    confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                                }
                            });
                        }
                    },
                    error: function(error) {
                        // console.log(error);
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "An error occurred!",
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'Close',
                            customClass: {
                                confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                            }
                        });
                    }
                });
            }
        }

        function testLandingPage() {
            let content = $("#content").val();
            // console.log(content);
            $.ajax({
                url: "{{ route('testLandingPage') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    html: content
                },
                success: function(response) {
                    // console.log(response.preview_id);
                    id = response.preview_id;
                    if (response.status === "success") {
                        window.open("{{ route('showPagePreview', ['id' => '__ID__']) }}".replace('__ID__', id));
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.message,
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'Close',
                            customClass: {
                                confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                            }
                        });
                    }
                },
            });
        }

        function showModalEditLandingPage(id) {
            let LandingPage = landingPages.find(x => x.id === id);
            $("#landing_name").val(LandingPage.name);
            $("#content").val(LandingPage.html);
            $("#submitted-checkbox").prop("checked", LandingPage.capture_credentials == 1 ? true : false);
            $("#passwords-checkbox").prop("checked", LandingPage.capture_passwords == 1 ? true : false);
            $("#redirect_url").val(LandingPage.redirect_url);
            $("#title-add-landing-page-modal").text('Update Landing Page');
            $("#button-for-pages").text('Update');
            $("#button-for-pages").removeAttr('onclick').attr('onclick',
                `editLandingPage(${id})`);
            showModal('add-landing-page-modal');
            showWarning();
        }

        function editLandingPage(id) {
            preventDoubleClick('button-for-pages', true);
            let name = $("#landing_name").val();
            let submitted = $("#submitted-checkbox").is(":checked") ? 1 : 0;
            let password = $("#passwords-checkbox").is(":checked") ? 1 : 0;
            let content = $("#content").val();
            let url = $("#redirect_url").val();
            $.ajax({
                url: "{{ route('updateLandingPage') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    landing_name: name,
                    html_content: content,
                    capture_credentials: submitted,
                    capture_passwords: password,
                    redirect_url: url
                },
                success: function(response) {
                    // console.log(response);
                    if (response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.message,
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'Close',
                            customClass: {
                                confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                preventDoubleClick('button-for-pages', false);
                                hideModal('add-landing-page-modal')
                            }
                        });
                        getLandingPage();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: response.message,
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'Close',
                            customClass: {
                                confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                            }
                        });
                    }
                },
                error: function(error) {
                    // console.log(error);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "An error occurred!",
                        confirmButtonColor: '#10b981',
                        confirmButtonText: 'Close',
                        customClass: {
                            confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                        }
                    });
                }
            });

        }

        function deleteLandingPage(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#d97706',
                reverseButtons: true,
                confirmButtonText: 'Yes, remove it!',
                cancelButtonText: 'No, cancel!',
                customClass: {
                    confirmButton: 'bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-r',
                    cancelButton: 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('deleteLandingPage') }}",
                        type: "POST",
                        data: {
                            id,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            getLandingPage();
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Landing Page has been deleted!',
                                confirmButtonColor: '#10b981',
                                confirmButtonText: 'Close',
                                customClass: {
                                    confirmButton: 'bg-blue-500 text-white rounded-lg px-4 py-2'
                                }
                            });
                        }
                    });
                }
            })
        }
    </script>
@endsection
