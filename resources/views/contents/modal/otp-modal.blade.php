<div id="otp-modal" class="fixed hidden inset-0 z-50 flex items-center justify-center">
    <div class="bg-gray-800 p-6 rounded-lg shadow-lg w-80">
        <h2 class="text-xl font-bold mb-4 text-center text-white">Enter OTP</h2>
        <p class="text-sm text-gray-400 mb-6 text-center">Please enter the 6-digit code sent to your email.</p>
        <div class="flex justify-center space-x-2">
            <input type="text" maxlength="1" id="otp-1"
                class="otp-input w-10 h-12 text-center border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" maxlength="1" id="otp-2"
                class="otp-input w-10 h-12 text-center border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" maxlength="1" id="otp-3"
                class="otp-input w-10 h-12 text-center border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" maxlength="1" id="otp-4"
                class="otp-input w-10 h-12 text-center border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" maxlength="1" id="otp-5"
                class="otp-input w-10 h-12 text-center border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" maxlength="1" id="otp-6"
                class="otp-input w-10 h-12 text-center border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <p class="text-sm text-gray-400 mt-4 text-center">Didn't receive the code? <a onclick="resendOTP()"
                class="text-blue-500">Resend</a></p>
        <button onclick="verifyOTP()"
            class="mt-6 w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600">Verify</button>
    </div>
</div>
