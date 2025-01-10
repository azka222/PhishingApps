@extends('layouts.master-login')
@section('title', 'Login')
@section('content')
    <div class="grid grid-cols-3">
        <fieldset id="login" class="lg:col-span-2 col-span-3">
            <div class='flex items-center justify-center min-h-screen bg-darkerBlue p-4'>
                <div class='relative bg-blueBlue rounded-3xl shadow-lg p-8  w-full max-w-md mx-auto text-white'>
                    <!-- Logo -->
                    <div class="flex items-center justify-center">
                        <img src="{{asset('image/kittyoEat.png')}}" alt="Logo" class="w-24 h-auto object-cover">
                    </div>
                    <!-- Header -->
                    <div class='text-4xl font-outfit text-center mt-4'>
                        <span class="font-normal">Login to </span>
                        <span class="font-bold text-skyBlue">FischSim</span>
                    </div>
                    <!-- Email input -->
                    <div class="mt-8">
                        <label for="user_email"
                            class="block mb-2  text-xs md:text-sm sm:text-base font-medium">Your email</label>
                        <input type="email" id="login_email"
                            class="w-full p-3 border rounded-lg text-gray-900 focus:ring-2 text-xs md:text-sm focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter your email" required />
                    </div>
                    <!-- Password Input -->
                    <div class="mt-6">
                        <label for="Password"
                            class="block mb-2 text-xs md:text-sm sm:text-base font-medium">Your password</label>
                        <input type="password" id="login_password"
                            class="w-full p-3 border rounded-lg text-gray-900 text-xs md:text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Enter your password" required />
                    </div>
                    <!-- Remember me & Reset Password -->
                    <div class="flex items-center justify-between px-1 mt-4">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox"
                                class="w-4 h-4 rounded border-gray-300 focus:ring-2 focus:ring-blue-500">
                            <label for="remember" class="ml-2 text-xs md:text-sm text-gray-300">Remember me?</label>
                        </div>
                        <a href="{{ route('forgotPasswordView') }}" class="text-xs md:text-sm text-blue-400 hover:underline">Reset Password</a>
                    </div>
                     <!-- Error Message  -->
                    <div class="pt-8">
                        <div id="error_message_field_login" hidden>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md relative"
                                role="alert">
                                <strong class="font-bold">Whoops!</strong>
                                <span class="block sm:inline">There were some problems with your input.</span>
                                <ul id="error_message_login"class="mt-3 list-disc list-inside text-sm">
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Login button -->
                    <div class="mt-4">
                        <button onclick="login()"
                            class="w-full text-xs md:text-sm bg-greyishBlue text-white py-3 rounded-lg hover:bg-blue-500 transition duration-300 ease-in-out">Login</button>
                        <!-- Dont have account -->
                        <div class="mt-4 text-center text-white text-xs md:text-sm">
                            <span>Don't have an account?</span>
                            <a onclick="registerView()" class="text-blue-400 hover:underline">Register</a>
                        </div>
                    </div>
                </div>
        </fieldset>
        <!-- Fun fact area -->
        <fieldset id="content" class="col-span-1 lg:block hidden">
            <div class="min-h-screen flex items-center justify-center bg-skyBlue">
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
