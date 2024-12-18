@extends('layouts.master')
@section('title', 'User Setting')
@include('contents.modal.edit-profile-modal')
@include('contents.modal.otp-modal')

@section('content')
    <div class="flex justify-center h-screen pt-28 pe-4 ps-4 bg-gray-50 dark:bg-gray-800">
        <div class="w-4/5 h-4/5 p-4 grid grid-cols-3 bg-gray-200 dark:bg-gray-600 rounded-xl">
            <div class="col-span-1 border-e-2 border-e-gray-900 dark:border-e-gray-100 pe-2">
                <div id="default-sidebar" class="" aria-label="Sidebar">
                    <div class="p-4 overflow-y-auto ">
                        <div class="mb-2">
                            <div id="button-setting-profile" onclick="handleSidebar('profile')"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                                        clip-rule="evenodd" />
                                </svg>

                                <span class="ms-3">Profile</span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div id="button-setting-security" onclick="handleSidebar('security')"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="ms-3">Security</span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div id="button-setting-company" onclick="handleSidebar('company')"
                                class="side-button flex items-center p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="ms-3">Company</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-2 ps-2">
                <fieldset id="content-profile" class="content-user-setting p-4">
                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-xl">
                        <div class="flex flex-col gap-4">
                            <div class="p-4 bg-gray-300 dark:bg-gray-700 rounded-xl">
                                <div class="flex flex-row justify-between">
                                    <div class="flex flex-row items-center justify-start ps-4 gap-8 ">
                                        <div class="h-full flex items-center">
                                            <img src="{{ asset('image/user.png') }}" class="w-20 h-20 rounded-full">
                                        </div>
                                        <div class="h-full flex gap-4 items-center">
                                            <div>
                                                <h1 id="username" class="text-xl font-semibold dark:text-white">User Name
                                                </h1>
                                                <p id="company_display" class="text-sm dark:text-white">Company Name</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center p-4">
                                        <button onclick="showEditProfileModal()"
                                            class="flex items-center p-2 rounded-lg  bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-gray-900 dark:text-white">
                                            <span class="ms-2 me-2 text-sm text-white">Edit</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                                class="size-4">
                                                <path
                                                    d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                <path
                                                    d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full h-4/5 bg-gray-300 dark:bg-gray-700 rounded-xl">
                                <div class="grid grid-cols-2 p-4 gap-4">
                                    <div class="ps-2 pt-2 col-span-1">
                                        <h1 class="text-md dark:text-white font-semibold">First Name</h1>
                                        <h2 id="first_name_display" class="text-sm pt-2 dark:text-white"></h2>
                                    </div>
                                    <div class="ps-2 pt-2 col-span-1">
                                        <h1 class="text-md dark:text-white font-semibold">Last Name</h1>
                                        <h2 id="last_name_display" class="text-sm pt-2 dark:text-white"></h2>
                                    </div>
                                    <div class="ps-2 pt-2 col-span-1">
                                        <h1 class="text-md dark:text-white font-semibold">Phone Number</h1>
                                        <h2 id="phone_number_display" class="text-sm pt-2 dark:text-white"></h2>
                                    </div>
                                    <div class="ps-2 pt-2 col-span-1 mb-4">
                                        <h1 class="text-md dark:text-white font-semibold">Gender</h1>
                                        <h2 id="gender_display" class="text-sm pt-2 dark:text-white"></h2>
                                    </div>

                                    <div class="relative flex items-center justify-center col-span-2">
                                        <hr class="w-full border-gray-400 dark:border-gray-500">
                                        <span
                                            class="absolute px-3 text-gray-700 rounded-full bg-gray-200 dark:bg-gray-600 dark:text-white">Additional
                                            Info</span>
                                    </div>

                                    <div class="ps-2 pt-4 col-span-1">
                                        <h1 class="text-md dark:text-white font-semibold">Company Address</h1>
                                        <h2 id="address_display" class="text-sm pt-2 dark:text-white">Not Set</h2>
                                    </div>
                                    <div class="ps-2 pt-4 col-span-1">
                                        <h1 class="text-md dark:text-white font-semibold">Company Type</h1>
                                        <h2 id="company_type_display" class="text-sm pt-2 dark:text-white">Not Set</h2>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </fieldset>
                <fieldset id="content-security" class="content-user-setting p-4">
                    <div class="w-full bg-gray-300 dark:bg-gray-700 rounded-xl p-4">
                        <h1 class="text-xl font-semibold dark:text-white">Security</h1>
                        <p class="text-sm dark:text-white">This is the security setting page</p>

                        <div class="mt-4 mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New
                                Password</label>
                            <div class="flex pb-4 items-center gap-2">
                                <input type="password" name="password" id="password" disabled
                                    class="mt-1 block w-2/5 p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                <button onclick="authCheckPassword()" id="button-password-check"
                                    class="bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white p-2 rounded-lg mt-1">
                                    Change
                                </button>
                                <div id="button-password-group" hidden>
                                    <button onclick="changePassword()"
                                        class="me-1 bg-green-600 dark:bg-green-700 hover:bg-green-700 dark:hover:bg-green-800 text-white p-2 rounded-lg mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button onclick="cancelChangePassword()"
                                        class="bg-red-600 dark:bg-red-700 hover:bg-red-700 dark:hover:bg-red-800 text-white p-2 rounded-lg mt-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-6">
                                            <path fill-rule="evenodd"
                                                d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
            </div>
            </fieldset>
        </div>


    </div>
    </div>


    <script>
        let active = ' bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-800 text-white';
        let inactive =
            ' bg-gray-300 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-700 text-gray-900 dark:text-white';

        let profile = null;

        $(document).ready(function() {
            firstRender();
            getProfile();

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

        })

        function firstRender() {
            $(".side-button").addClass(inactive).removeClass(active);
            $(".content-user-setting").hide();
            $("#button-setting-profile").removeClass(inactive).addClass(active);
            $("#content-profile").show();
        }

        function handleSidebar(content) {
            $(".side-button").removeClass(active).addClass(inactive);
            $("#button-setting-" + content).removeClass(inactive).addClass(active);
            $(".content-user-setting").hide();
            $("#content-" + content).show();
        }

        function getProfile() {
            $.ajax({
                url: "{{ route('getProfileDetails') }}",
                type: "GET",
                success: function(response) {
                    profile = response.data;
                    setProfileInformation(profile);
                }
            })
        }

        function setProfileInformation(profile) {
            $("#first_name_display").text(profile.first_name);
            $("#last_name_display").text(profile.last_name);
            $("#phone_number_display").text(profile.phone);
            $("#gender_display").text(profile.gender);
            $("#address_display").text(profile.company ? profile.company.address : "Not Set");
            $("#company_type_display").text(profile.company ? profile.company.type : "Not Set");
            $("#username").text(profile.email);
            $("#company_display").text(profile.company ? profile.company.name : "");
        }

        function showEditProfileModal() {
            showModal("edit-profile-modal");
            $("#first_name").val(profile.first_name);
            $("#last_name").val(profile.last_name);
            $("#phone_number").val(profile.phone);
            $("#gender").val(profile.gender);
            $("#email").val(profile.email);
        }

        function submitEditModal() {
            let data = {
                id: profile.id,
                first_name: $("#first_name").val(),
                last_name: $("#last_name").val(),
                phone: $("#phone_number").val(),
                gender: $("#gender").val(),
                email: $("#email").val(),
                _token: "{{ csrf_token() }}"
            }
            $.ajax({
                url: "{{ route('updateProfile') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    if (response.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonColor: '#22c55e',
                            confirmButtonText: 'Ok'
                        })
                        getProfile();
                        hideModal("edit-profile-modal");
                    }
                },
                error: function(xhr) {
                    var error = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Close'
                    });
                }
            })
        }

        function authCheckPassword() {
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let userId = profile.id;
            $.ajax({
                url: "{{ route('sendOtp') }}",
                type: "POST",
                data: {
                    id: userId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        title: "<strong>Check your mailbox!</strong>",
                        icon: "info",
                        text: "We have sent an OTP to your email address. Please check your email and enter the OTP to continue.",
                        closeOnClickOutside: false,
                        confirmButtonColor: '#40c3ed',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            showModal("otp-modal");
                        }
                    });
                },
                error: function(xhr) {}
            })
        }

        function verifyOTP() {
            let data = {
                otp: $("#otp-1").val() + $("#otp-2").val() + $("#otp-3").val() + $("#otp-4").val() + $("#otp-5").val() +
                    $("#otp-6").val(),
                _token: "{{ csrf_token() }}"
            }
            $.ajax({
                url: "{{ route('verifyOtp') }}",
                type: "POST",
                data: data,
                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'Ok'
                    })
                    $("#password").prop("disabled", false);
                    $("#button-password-group").show();
                    $("#button-password-check").hide();
                    hideModal("otp-modal");

                },
                error: function(xhr) {
                    var error = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Close'
                    });
                }
            })
        }

        function resendOTP(){
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            let userId = profile.id;
            $.ajax({
                url: "{{ route('sendOtp') }}",
                type: "POST",
                data: {
                    id: userId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'Ok'
                    })
                },
                error: function(xhr) {}
            })
        }

        function changePassword(){
            let data = {
                id: profile.id,
                password: $("#password").val(),
                _token: "{{ csrf_token() }}"
            }
            $.ajax({
                url: "{{ route('changePassword') }}",
                type: "POST",
                data: data,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        confirmButtonColor: '#22c55e',
                        confirmButtonText: 'Ok'
                    })
                    cancelChangePassword();
                },
                error: function(xhr) {
                    var error = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: error.message,
                        confirmButtonColor: '#ef4444',
                        confirmButtonText: 'Close'
                    });
                }
            })
        }

        function cancelChangePassword(){
            $("#password").prop("disabled", true);
            $("#button-password-group").hide();
            $("#button-password-check").show();
            $("#password").val("");
        }
    </script>
@endsection
