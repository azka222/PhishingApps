@extends('layouts.master-login')
@section('title', 'Fischsim - Login')
@include('contents.modal.login.otp-modal')
@section('content')
    <div class="grid grid-cols-3">
        <fieldset id="login" class="lg:col-span-2 col-span-3">
            <div class='flex items-center justify-center min-h-screen bg-darkerBlue p-4'>
                <div class='relative bg-blueBlue rounded-3xl shadow-lg p-8  w-full max-w-md mx-auto text-white'>
                    <!-- Logo -->
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('image/kittyoEat.png') }}" alt="Logo" class="w-24 h-auto object-cover">
                    </div>
                    <!-- Header -->
                    <div class='text-4xl font-outfit text-center mt-4'>
                        <span class="font-normal">Login to </span>
                        <span class="font-bold text-skyBlue">FischSim</span>
                    </div>
                    <div class="mt-4 dark:border-gray-700">
                        <ul class="flex flex-wrap p-4 text-sm font-medium text-center" id="default-tab"
                            data-tabs-toggle="#default-tab-content" role="tablist">
                            <li class="me-2" role="presentation">
                                <button class="inline-block border-b-2 py-2 px-4 " id="profile-tab"
                                    data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">Admin</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block border-b-2 py-2 px-4 " id="dashboard-tab"
                                    data-tabs-target="#dashboard" type="button" role="tab" aria-controls="dashboard"
                                    aria-selected="false">Employee</button>
                            </li>
                        </ul>
                    </div>
                    <div id="default-tab-content">
                        <div class="hidden p-4 rounded-lg " id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <!-- Email input -->
                            <div class="">
                                <label for="user_email" class="block mb-2  text-xs md:text-sm sm:text-base font-medium">Your
                                    email</label>
                                <input type="email" id="login_email"
                                    class="w-full p-3 border rounded-lg text-gray-900 focus:ring-2 text-xs md:text-sm focus:ring-blue-500 focus:outline-none"
                                    placeholder="Enter your email" required />
                            </div>
                            <!-- Password Input -->
                            <div class="mt-6 relative">
                                <label for="Password" class="block mb-2 text-xs md:text-sm sm:text-base font-medium">
                                    Your password
                                </label>
                                <div class="relative">
                                    <input type="password" id="login_password"
                                        class="w-full p-3 pr-10 border rounded-lg text-gray-900 text-xs md:text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        placeholder="Enter your password" required />
                                    <!-- SVG Icon -->
                                    <button class="show-password absolute  top-1/2 -translate-y-1/2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 w-6 h-6 cursor-pointer">
                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                            <path fill-rule="evenodd"
                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <!-- Remember me & Reset Password -->
                            <div class="flex items-center justify-between px-1 mt-4">
                                <div class="flex items-center">
                                    <input id="remember" type="checkbox"
                                        class="w-4 h-4 rounded border-gray-300 focus:ring-2 focus:ring-blue-500">
                                    <label for="remember" class="ml-2 text-xs md:text-sm text-gray-300">Remember me?</label>
                                </div>
                                <a href="{{ route('forgotPasswordView') }}"
                                    class="text-xs md:text-sm text-blue-400 hover:underline">Reset Password</a>
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
                        <div class="hidden p-4 rounded-lg " id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">

                            <div class="">
                                <label for="employee_email"
                                    class="block mb-2 text-xs md:text-sm sm:text-base font-medium">Your
                                    email</label>

                                <input type="email" id="employee_email"
                                    class="w-full p-3 border rounded-lg text-gray-900 focus:ring-2 text-xs md:text-sm focus:ring-blue-500 focus:outline-none"
                                    placeholder="Enter your email" required />

                            </div>
                            <div class="mt-4">
                                <button onclick="sendEmployeeOTP()"
                                    class="w-full text-xs md:text-sm bg-greyishBlue text-white py-3 rounded-lg hover:bg-blue-500 transition duration-300 ease-in-out">Generate
                                    OTP</button>
                            </div>
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
        document.addEventListener("DOMContentLoaded", () => {
            const passwordInput = document.getElementById("login_password");
            const showPasswordBtn = document.querySelector(".show-password");

            showPasswordBtn.addEventListener("mousedown", () => {
                passwordInput.type = "text";
            });
            showPasswordBtn.addEventListener("mouseup", () => {
                passwordInput.type = "password";
            });
            showPasswordBtn.addEventListener("mouseleave", () => {
                passwordInput.type = "password";
            });
        });
        $(document).ready(function() {
            const otpInputs = $(".otp-input");
            otpInputs.on("input", function() {
                const input = $(this);
                const value = input.val().replace(/[^0-9]/g, "");
                input.val(value);

                if (value.length === 1) {
                    input.next(".otp-input").focus();
                }
            });

            otpInputs.on("keydown", function(e) {
                if (e.key === "Backspace" && !$(this).val()) {
                    $(this).prev(".otp-input").focus();
                }
            });

            $(document).on('keydown', function(e) {
                if (e.key === 'Enter') {
                    login();
                }
            });
        });

        function registerView() {
            window.location.href = "{{ route('registerView') }}";

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
                    var errors = errorMessage.message;
                    $('#error_message_field_login').show();
                    $('#error_message_login').empty();
                    if (errors) {
                        $('#error_message_login').append('<li>' + errors + '</li>');
                    }
                }


            });
        }

        function sendEmployeeOTP() {
            showModal('otp-modal');
        }
    </script>

@endsection
