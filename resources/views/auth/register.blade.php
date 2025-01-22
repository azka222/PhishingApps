@extends('layouts.master-login')
@section('title', 'Fischsim - Register')
@section('content')
    <div class="grid grid-cols-3 bg-darkerBlue">
        <fieldset id="register" class="lg:col-span-2 col-span-3" hidden>
            <div class="min-h-screen flex items-center justify-center bg-darkerBlue text-white">
                <div class="w-full max-w-2xl ">
                    <div class="bg-blueBlue shadow-md rounded-3xl p-8 m-8">
                        <div class="mb-4 text-xl font-bold">{{ __('Register') }}</div>
                        <div class="grid grid-cols-2 gap-4 bg-red mb-8">
                            <div class="md:col-span-1 col-span-2">
                                <div>
                                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-90">First
                                        name</label>
                                    <input type="text" id="first_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                        placeholder="Enter your first name" required />
                                </div>
                            </div>
                            <div class="md:col-span-1 col-span-2">
                                <div>
                                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-90">Last
                                        name</label>
                                    <input type="text" id="last_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                        placeholder="Enter your last name" required />
                                </div>
                            </div>
                            <div class="md:col-span-1 col-span-2">
                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-90">Email</label>
                                    <input type="email" id="email_user"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                        placeholder="Enter your email" required />
                                </div>
                            </div>
                            <div class="md:col-span-1 col-span-2">
                                <div>
                                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-90">Gender</label>
                                    <select id="gender"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        required>
                                        <option value="" disabled selected>Select your gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="md:col-span-1 col-span-2">
                                <div>
                                    <label for="password"
                                        class="block mb-2 text-sm font-medium text-gray-90">Password</label>
                                    <input type="password" id="new_password"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                        placeholder="Enter your password" required />
                                </div>
                            </div>
                            <div class="md:col-span-1 col-span-2">
                                <div>
                                    <label for="password_confirmation"
                                        class="block mb-2 text-sm font-medium text-gray-90">Confirm
                                        Password</label>
                                    <input type="password" id="password_confirmation"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                        placeholder="Confirm your password" required />
                                </div>
                            </div>
                            <div class="md:col-span-1 col-span-2">
                                <div>
                                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-90">Phone
                                        Number</label>
                                    <input type="text" id="phone"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                        placeholder="Enter your phone number" required />
                                </div>
                            </div>

                            <div class="col-span-2" id="error_message_field" hidden>
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                    role="alert">
                                    <strong class="font-bold">Whoops!</strong>
                                    <span class="block sm:inline">There were some problems with your input.</span>
                                    <ul id="error_message"class="mt-3 list-disc list-inside text-sm text-red-600">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-center flex-col items-center">
                            <button type="button" onclick="register()"
                                class="w-full max-w-64 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Register</button>
                            <div class="mt-4 text-center">
                                <span>Already have an account?</span>
                                <a onclick="loginView()" class="text-blue-600 hover:underline">Login</a>
                            </div>
                        </div>
                    </div>
        </fieldset>
        <fieldset id="chooseCompany" class="lg:col-span-2 col-span-3" hidden>
            <div class="min-h-screen flex items-center justify-center p-4">
                <div class="w-full max-w-2xl bg-blueBlue shadow-lg rounded-3xl p-8">
                    <!-- Header -->
                    <div class=" mb-6 text-white">
                        <div class="text-center text-3xl font-bold pb-8">Company</div>
                        <!-- Select -->
                        <div class="mb-6">
                            <div class="md:col-span-2 col-span-2">
                                <div class="">
                                    <label for="company"
                                        class="flex block mb-2 text-sm font-medium text-white dark:text-white">Select
                                        Company</label>
                                    <select class="js-example-basic-single" style="width: 100%;" id="selectCompany"
                                        onchange="checkCompany(this.value)" name="state">
                                    </select>
                                </div>
                            </div>
                            <!-- Error Message-->
                            <div class="col-span-2 pt-4" id="error_message_field_company" hidden>
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md relative"
                                    role="alert">
                                    <strong class="font-bold">Whoops!</strong>
                                    <span class="block sm:inline">There were some problems with your input.</span>
                                    <ul id="error_message_company"class="mt-3 list-disc list-inside text-sm">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-span-2 pt-4" id="success_message_field_company" hidden>
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md relative"
                                    role="alert">
                                    <strong class="font-bold">Yeay!</strong>
                                    <span class="block sm:inline">You can use this company.</span>
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="flex flex-col items-center">
                            <div class="flex w-full items-center gap-2 justify-center">
                                <button id="chooseCompanyBtn" type="button" onclick="createCompanyView()"
                                    class="w-full max-w-32 bg-[#38A169] text-white py-2 rounded-lg hover:bg-[#2F855A] transition duration-300 ease-in-out">Create</button>
                                <button id="nextToRegisterUser" type="button" onclick="registerView()" hidden
                                    class="w-full max-w-32 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">Next</button>
                            </div>
                            <!-- Login -->
                            <div class="mt-2 text-center text-white">
                                <span>Already have an account?</span>
                                <a onclick="loginView()" class="text-blue-400 hover:underline">Login</a>
                            </div>
                        </div>
        </fieldset>
        <fieldset id="createCompany" class="lg:col-span-2 col-span-3" hidden>
            <div class="min-h-screen p-4 flex items-center justify-center bg-darkerBlue text-white">
                <div class="w-full bg-blueBlue max-w-2xl rounded-3xl">
                    <div class="shadow-md rounded-lg p-8 m-8 mb-4">
                        <div class="mb-4 text-xl font-bold">Create Company</div>
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="md:col-span-1 col-span-2">
                                <div>
                                    <label for="company_name" class="block mb-2 text-sm sm:text-base font-medium">Company
                                        Name</label>
                                    <input type="text" id="company_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                        placeholder="Enter your company name" required />
                                </div>
                            </div>
                            <div class="md:col-span-1 col-span-2">
                                <div>
                                    <label for="company_email" class="block mb-2 text-sm sm:text-base font-medium">Company
                                        Email</label>
                                    <input type="email" id="company_email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                        placeholder="Enter your company email" required />
                                </div>
                            </div>
                            <div class="md:col-span-2 col-span-2">
                                <div>
                                    <label for="company_address"
                                        class="block mb-2 text-sm sm:text-base font-medium">Company
                                        Address</label>
                                    <textarea id="company_address" rows="4"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="Enter your company address" required></textarea>
                                </div>

                                <div class="col-span-2 pt-4" id="error_message_field_company_create" hidden>
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                        role="alert">
                                        <strong class="font-bold">Whoops!</strong>
                                        <span class="block sm:inline">There were some problems with your input.</span>
                                        <ul
                                            id="error_message_company_create"class="mt-3 list-disc list-inside text-sm text-red-600">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-center flex-col items-center">
                            <button id="chooseCompanyBtn" type="button" onclick="createCompany()"
                                class="w-full max-w-64 bg-green-500 text-white py-2 rounded-lg hover:bg-blue-700">Create</button>
                            <button id="nextToRegisterUser" type="button" onclick="registerView()" hidden
                                class="w-full max-w-64 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Next</button>
                            <div class="mt-4 text-center">
                                <div class="mt-4 text-center">
                                    <span>Already have an account?</span>
                                    <a onclick="loginView()" class="text-blue-600 hover:underline">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset id="content" class="col-span-1 lg:block hidden">
            <div class="min-h-screen flex items-center justify-center bg-skyBlue">
                Nanti Jadiin Content Apa Gitu
            </div>
        </fieldset>
    </div>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({

            });
            $("#phone").on('input', function() {
                var phone = $(this).val();
                $(this).val(phone.replace(/[^0-9]/g, ''));
            });
            companyView();
        });

        function createCompanyView() {
            $('#createCompany').show();
            $('#chooseCompany').hide();
        }

        function createCompany() {

            $.ajax({
                url: "{{ route('createCompany') }}",
                type: 'POST',
                data: {
                    name: $('#company_name').val(),
                    email: $('#company_email').val(),
                    address: $('#company_address').val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Company created successfully.',
                        icon: 'success',
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            companyView();
                        }
                    })
                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    var errors = errorMessage.errors;
                    $('#error_message_field_company_create').show();
                    $('#error_message_company_create').empty();
                    $.each(errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            let data = `<li>${message}</li>`;
                            $('#error_message_company_create').append(data);
                        });
                    });
                }
            });
        }

        function companyView() {
            $('#register').hide();
            $('#chooseCompany').show();
            $("#error_message_field_company").hide();
            $("#success_message_field_company").hide();
            $("#selectCompany").val('');
            $('#chooseCompanyBtn').show();
            $('#nextToRegisterUser').hide();
            $("#createCompany").hide();
            getCompanies();
        }

        function registerView() {
            $('#register').show();
            $('#chooseCompany').hide();

        }

        function loginView() {
            window.location.href = "{{ route('loginView') }}";
        }

        function checkCompany(id) {
            $.ajax({
                url: "{{ route('checkCompany') }}",
                type: 'POST',
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    $('#error_message_field_company').hide();
                    $('#success_message_field_company').show();
                    // $('#chooseCompanyBtn').hide();
                    $('#nextToRegisterUser').show();

                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    var errors = errorMessage.message;
                    var suggest = errorMessage.suggest;
                    $('#chooseCompanyBtn').show();
                    $('#nextToRegisterUser').hide();
                    $("#success_message_field_company").hide();
                    $('#error_message_field_company').show();
                    $('#error_message_company').empty();
                    $('#error_message_company').append(`<li>${errors}</li>`);
                    $('#error_message_company').append(`<li>${suggest}</li>`);


                }
            })
        }

        function getCompanies() {
            $.ajax({
                url: "{{ route('getCompanies') }}",
                type: 'GET',
                success: function(response) {
                    let companies = response.data;
                    $("#selectCompany").empty();
                    $("#selectCompany").append('<option value="" selected disabled>Choose a company</option>');
                    $.each(companies, function(index, company) {
                        $("#selectCompany").append(
                            `<option value="${company.id}">${company.name}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }

        function register() {
            Swal.fire({
                title: 'Registering...',
                text: 'Please wait while we process your registration.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var company = $('#selectCompany').val();
            var email = $('#email_user').val();
            var password = $('#new_password').val();
            var password_confirmation = $('#password_confirmation').val();
            var phone = $('#phone').val();
            var gender = $('#gender').val();
            $.ajax({
                url: "{{ route('register') }}",
                type: 'POST',
                data: {
                    first_name: first_name,
                    last_name: last_name,
                    company: company,
                    email: email,
                    password: password,
                    password_confirmation: password_confirmation,
                    phone: phone,
                    gender: gender,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Check your mailbox to verify email.',
                        icon: 'success',
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'Login'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            loginView();
                        }
                    })
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    var errorMessage = JSON.parse(xhr.responseText);
                    var errors = errorMessage.errors;
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
@endsection
