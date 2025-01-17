@extends('layouts.master-login')
@section('title', 'Fischsim - Forgot Password')
@section('content')
    <div class="grid grid-cols-3 bg-darkerBlue">
        <fieldset id="forgot-password" class="lg:col-span-2 col-span-3">
            <div class="min-h-screen flex items-center justify-center p-4">
                <div class="w-full max-w-2xl bg-blueBlue shadow-lg rounded-3xl p-8">
                    <!-- Header -->
                    <div class="text-center mb-6 text-white">
                        <div class="text-3xl font-bold pb-8">Reset Password</div>
                        <!-- Select -->
                        <div class="mb-6">
                            <div class="md:col-span-2 col-span-2">
                                <label for="email" class="block mb-2 text-base font-medium">Your email</label>
                                <input type="email" id="email"
                                    class="w-full p-3 border rounded-lg text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    placeholder="Enter your email" required />
                            </div>
                            <!-- Error Message-->
                            <div class="col-span-2 pt-4" id="error_message_field_Password" hidden>
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-md relative"
                                    role="alert">
                                    <strong class="font-bold">Whoops!</strong>
                                    <span class="block sm:inline">There were some problems with your input.</span>
                                    <ul id="error_message_Password"class="mt-3 list-disc list-inside text-sm">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-span-2 pt-4" id="success_message_field_Password" hidden>
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-md relative"
                                    role="alert">
                                    <strong class="font-bold">Yeay!</strong>
                                    <span class="block sm:inline">A link has been sent to your email.</span>
                                </div>
                            </div>
                        </div>
                        <!-- Button -->
                        <div class="flex flex-col items-center">
                            <button id="choosePasswordBtn" type="button" onclick="sentLinkForgotPassword()"
                                class="w-full max-w-64 bg-[#38A169] text-white py-2 rounded-lg hover:bg-[#2F855A] transition duration-300 ease-in-out">Send
                                Link</button>
                            <!-- Login -->
                            <div class="mt-2 text-center text-white">
                                <span>Already have an account?</span>
                                <a href="{{ route('loginView') }}" class="text-blue-400 hover:underline">Login</a>
                            </div>
                        </div>
        </fieldset>
        <fieldset id="content" class="col-span-1 lg:block hidden">
            <div class="min-h-screen flex items-center justify-center bg-skyBlue">
                aaaaaaa
            </div>
        </fieldset>
    </div>

    <script>
        function sentLinkForgotPassword() {
            Swal.fire({
                title: 'Sending...',
                text: 'Please wait while we send the reset link to your email',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            let email = $('#email').val();
            $.ajax({
                url: "{{ route('forgotPassword') }}",
                type: "POST",
                data: {
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.close();
                    $('#success_message_field_Password').show();
                    $('#error_message_field_Password').hide();
                },
                error: function(xhr) {
                    Swal.close();
                    $('#error_message_field_Password').removeAttr('hidden');
                    $('#success_message_field_Password').attr('hidden', true);
                    $('#error_message_Password').empty();
                    var errorMessage = JSON.parse(xhr.responseText) ? JSON.parse(xhr.responseText) : xhr
                        .responseText;
                    var errors = errorMessage.errors ? errorMessage.errors : errorMessage;
                    $.each(errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            let data = `<li>${message}</li>`;
                            $('#error_message_Password').append(data);
                        });
                    });
                }
            })
        }
    </script>
@endsection
