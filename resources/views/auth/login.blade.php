@extends('layouts.master-login')
@section('title', 'Login')
@section('content')
    <div class="grid grid-cols-3">
        <fieldset id="login" class="lg:col-span-2 col-span-3">
            <div class='flex items-center justify-center min-h-screen bg-darkerBlue'>
                <div class='gap-5 p-8 bg-darkerBlue rounded-3xl min-h-[800px] max-2-[980px] min-w-[560px] max-2-[650px]'>
                    <div class='text-white pt-16'>
                        <span class="text-3xl font-normal font-sans">Login to </span>
                        <span class="text-3xl font-bold font-sans">FischSim</span>
                    </div>
                    <div class="pt-32">
                        <label for="user_email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" id="login_email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Enter your email" required />
                    </div>
                    <div class="pt-8">
                        <label for="Password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" id="login_password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Enter your password" required />
                    </div>
                    <div class="pt-8">
                        <div id="error_message_field_login" hidden>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                role="alert">
                                <strong class="font-bold">Whoops!</strong>
                                <span class="block sm:inline">There were some problems with your input.</span>
                                <ul id="error_message_login"class="mt-3 list-disc list-inside text-sm text-red-600">

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="pt-8">
                        <button onclick="login()"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 dark:bg-gray-800 dark:text-white">Login</button>
                        <div class="mt-4 text-center text-white">
                            <span>Don't have an account?</span>
                            <a onclick="registerView()" class="text-blue-600 hover:underline">Register</a>
                        </div>

                    </div>
                </div>
        </fieldset>
        <fieldset id="content" class="col-span-1 lg:block hidden">
            <div class="min-h-screen flex items-center justify-center bg-gray-200">
                aaaaaaa
            </div>
        </fieldset>

    </div>

    <script>
        $(document).ready(function() {
            $("#phone").on('input', function() {
                var phone = $(this).val();
                $(this).val(phone.replace(/[^0-9]/g, ''));
            });

            getCompanies();
        });

        function registerView() {
         window.location.href = "{{ route('registerView') }}";

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
                    $('#createCompanyBtn').hide();
                    $('#nextToRegisterUser').show();

                },
                error: function(xhr, status, error) {
                    var errorMessage = JSON.parse(xhr.responseText);
                    var errors = errorMessage.message;
                    var suggest = errorMessage.suggest;
                    $('#createCompanyBtn').show();
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

   
        function login() {
            Swal.fire({
                title: 'Logging in...',
                text: 'Please wait while we process your login.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            var email = $('#login_email').val();
            var password = $('#login_password').val();
            $.ajax({
                url: "{{ route('login') }}",
                type: 'POST',
                data: {
                    email: email,
                    password: password,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.close();
                    window.location.href = "{{ route('dashboard') }}";
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    console.log(xhr.responseText);
                    var errorMessage = JSON.parse(xhr.responseText) ? JSON.parse(xhr.responseText) : xhr
                        .responseText;
                    var errors = errorMessage.errors ? errorMessage.errors : errorMessage;
                    $('#error_message_field_login').show();
                    $('#error_message_login').empty();
                    $.each(errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            let data = `<li>${message}</li>`;
                            $('#error_message_login').append(data);
                        });
                    });
                }


            });
        }


       
    </script>

@endsection
