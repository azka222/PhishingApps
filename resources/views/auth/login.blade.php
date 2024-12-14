@extends('layouts.master')
@section('title', 'Login')
@section('content')
    <div class="grid grid-cols-3">
        <fieldset id="login" class="lg:col-span-2 col-span-3">
            <!-- <div class='flex items-center justify-center min-h-screen bg-skyBlue'>
                <div class="w-full max-w-md bg-grey-200">
                    <div class='grid grid-cols-10 gap-5 bg-darkerBlue/75 rounded-3xl min-h-[800px] max-2-[980px] min-w-[560px] max-2-[650px]'>
                         <div class='col-start-2 col-span-3 text-white pt-16'>
                            <span class="text-3xl font-normal font-sans">Login to </span>
                            <span class="text-3xl font-bold font-sans">FischSim</span>
                        </div>
                    </div>
                </div>
            </div>
         </div> -->
         <div class='flex items-center justify-center min-h-screen bg-darkerBlue'>
            <div class='gap-5 bg-darkerBlue rounded-3xl min-h-[800px] max-2-[980px] min-w-[560px] max-2-[650px]'>
                <div class='text-white pt-16'>
                    <span class="text-3xl font-normal font-sans">Login to </span>
                    <span class="text-3xl font-bold font-sans">FischSim</span>
                </div>
                <div class="pt-32">
                    <label for="user_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="text" id="user_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your email" required />
                </div>
                <div class="pt-8">
                    <label for="Password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="text" id="Password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Enter your password" required />
                </div>

                </div>
            </div>
         </div>
        </fieldset>
        <fieldset id="register" class="lg:col-span-2 col-span-3" hidden>
            <div class="min-h-screen flex items-center justify-center bg-gray-100">
                <div class="w-full max-w-2xl ">
                    <div class="bg-white shadow-md rounded-lg p-8 m-8 mb-4">
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
                                    <label for="company"
                                        class="block mb-2 text-sm font-medium text-gray-90">Company</label>
                                    <input type="text" id="company"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                        placeholder="Enter your company" required />
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
        });

        function registerView() {
            $('#login').hide();
            $('#register').show();

        }

        function loginView() {
            $('#login').show();
            $('#register').hide();
        }

        function login() {
            var email = $('#email').val();
            var password = $('#password').val();
            $.ajax({
                url: "{{ route('login') }}",
                type: 'POST',
                data: {
                    email: email,
                    password: password,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                },

            });
        }

        function register() {
            var first_name = $('#first_name').val();
            var last_name = $('#last_name').val();
            var company = $('#company').val();
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
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
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
