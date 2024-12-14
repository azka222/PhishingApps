@extends('layouts.master')
@section('title', 'Login')
@section('content')
    <div class="grid grid-cols-3">
        <fieldset id="login" class="lg:col-span-2 col-span-3">
            <div class="min-h-screen flex items-center justify-center bg-gray-100">
                <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
                    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required>
                    </div>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <input type="checkbox" id="remember" name="remember" class="mr-2">
                            <label for="remember" class="text-gray-700">Remember Me</label>
                        </div>
                        <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
                    </div>
                    <button type="button" onclick="login()"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Login</button>
                    <div class="mt-4 text-center">
                        <span>Don't have an account?</span>
                        <a onclick="registerView()" class="text-blue-600 hover:underline">Register</a>
                    </div>
                    <div class="md:hidden block ">

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
