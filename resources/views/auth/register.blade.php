@extends('layouts.master')
@section('title', 'Register')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded p-4 mb-4">
                <div class="mb-4 text-xl font-bold">{{ __('Register') }}</div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 ">First
                                name</label>
                            <input type="text" id="first_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="John" required />
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email"
                            class="block text-gray-700 text-sm font-bold mb-2">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password"
                            class="block text-gray-700 text-sm font-bold mb-2">{{ __('Password') }}</label>
                        <input id="password" type="password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                            name="password" required autocomplete="new-password">
                        @error('password')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm"
                            class="block text-gray-700 text-sm font-bold mb-2">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Phone') }}</label>
                        <input id="phone" type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('phone') border-red-500 @enderror"
                            name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                        @error('phone')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address"
                            class="block text-gray-700 text-sm font-bold mb-2">{{ __('Address') }}</label>
                        <input id="address" type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address') border-red-500 @enderror"
                            name="address" value="{{ old('address') }}" required autocomplete="address">
                        @error('address')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="city"
                            class="block text-gray-700 text-sm font-bold mb-2">{{ __('City') }}</label>
                        <input id="city" type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('city') border-red-500 @enderror"
                            name="city" value="{{ old('city') }}" required autocomplete="city">
                        @error('city')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="country"
                            class="block text-gray-700 text-sm font-bold mb-2">{{ __('Country') }}</label>
                        <input id="country" type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('country') border-red-500 @enderror"
                            name="country" value="{{ old('country') }}" required autocomplete="country">
                        @error('country')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
