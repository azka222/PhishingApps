@extends('layouts.master')

@section('content')
    <div class="grid grid-cols-3">
        <div class="col-span-3 md:col-span-2">
            <div class="min-h-screen flex items-center justify-center bg-gray-100">
                <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
                    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Password</label>
                        <input type="password" id="password" name="password"
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
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Login</button>
                    <div class="md:hidden block ">
                        <div class="mt-4 text-center">
                            <span>Don't have an account?</span>
                            <a href="" class="text-blue-600 hover:underline">Register</a>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
        <div class="md:col-span-1 hidden md:block bg-gray-200">
            <div class="h-screen flex items-center justify-center">
                <div class="p-4">
                    <h1 id="register-info" class="text-4xl font-bold text-center"></h1>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
               typeWriter();
            });

            
            function typeWriter() {
                const text = "Are you new here? Register now!";
                const registerInfo = document.getElementById('register-info');
                let index = 0;

                    if (index < text.length) {
                        registerInfo.innerHTML += text.charAt(index);
                        index++;
                        setTimeout(typeWriter, 100);
                    } else {
                        setTimeout(() => {
                            registerInfo.innerHTML = '';
                            index = 0;
                            typeWriter();
                        }, 2000);
                    }
                }
        </script>
    @endsection
