@php
    $url = explode('/', Route::current()->uri)[0];
    $home = $target = $services = $pricing = $contact = $dashboard = false;
    switch ($url) {
        case 'dashboard':
            $dashboard = true;
            break;
        case 'target':
            $target = true;
            break;
        case 'services':
            $services = true;
            break;
        case 'pricing':
            $pricing = true;
            break;
        case 'contact':
            $contact = true;
            break;
        default:
            $home = true;
            break;
    }

@endphp
<nav class="border-b-2 p-2 border-b-gray-900 bg-white border-gray-200 dark:border-b-gray-200 dark:bg-gray-900" id="navbar-header">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto">
        <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Fischsim</span>
        </a>
        <div class="flex flex-row items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <div class="flex flex-col items-center p-4">
                <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                    class="flex items-center text-sm font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:me-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white"
                    type="button">
                    <img class="w-10 h-10 rounded-full" src="{{ asset('/image/user.png') }}" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownAvatarName"
                    class="z-10 hidden absolute mt-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="text-sm text-gray-900 px-2 pt-2 dark:text-white">
                        <div class="font-medium ">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                        <div class="truncate text-xs pb-2">{{ Auth::user()->email }}</div>
                    </div>
                    <ul class="py-2 px-2 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                        <li>
                            <a href="#"
                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('userSettingView') }}"
                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                        </li>
                    </ul>
                    <div class="py-2 px-2">
                        <a href="{{ route('logout') }}"
                            class="block py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                            out</a>
                    </div>
                </div>
            </div>

            <button id="theme-toggle"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 dark:bg-yellow-500 dark:hover:bg-yellow-600">
                <div id="svg">
                </div>

            </button>

            <button data-collapse-toggle="navbar-user" id="toggle-navbar" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-user" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div id="targetEl" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
            id="navbar-user">
            <div class="flex flex-row gap-4">
                <div>
                    <button>
                        <a href="{{ url('/dashboard') }}"
                            class="px-3 py-2 text-sm font-medium border-2 {{ $dashboard ? 'text-blue-600 border-blue-600 dark:text-blue-700  dark:border-blue-700' : 'text-gray-900 dark:text-white border-gray-900 dark:border-white ' }} rounded-full">Dashboard</a>
                    </button>
                </div>
                <div>
                    <button>
                        <a href="{{ url('/target') }}"
                            class="px-3 py-2 text-sm font-medium border-2 {{ $target ? 'text-blue-600 border-blue-600 dark:text-blue-700  dark:border-blue-700' : 'text-gray-900 dark:text-white border-gray-900 dark:border-white ' }} rounded-full">Target</a>
                    </button>
                </div>
                <div>
                    <button>
                        <a href="{{ url('/services') }}"
                            class="px-3 py-2 text-sm font-medium border-2 {{ $services ? 'text-blue-600 border-blue-600 dark:text-blue-700  dark:border-blue-700' : 'text-gray-900 dark:text-white border-gray-900 dark:border-white ' }} rounded-full">Services</a>
                    </button>
                </div>
                <div>
                    <button>
                        <a href="{{ url('/pricing') }}"
                            class="px-3 py-2 text-sm font-medium border-2 {{ $pricing ? 'text-blue-600 border-blue-600 dark:text-blue-700  dark:border-blue-700' : 'text-gray-900 dark:text-white border-gray-900 dark:border-white ' }} rounded-full">Pricing</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    $(document).ready(function() {
        $("#toggle-navbar").click(function() {
            $("#navbar-user").toggleClass('hidden');
        });

        $("#dropdownAvatarNameButton").click(function() {
            $("#dropdownAvatarName").toggleClass('hidden');
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('#dropdownAvatarNameButton, #dropdownAvatarName').length) {
                $("#dropdownAvatarName").addClass('hidden');
            }
        });

        const themeToggleBtn = $('#theme-toggle');
        const body = $('body');
        if (localStorage.theme === 'dark') {
            body.addClass('dark');
            $("#svg").append(`
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>

            `);

        } else {
            body.removeClass('dark');
            $("#svg").append(` 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>`);
        }
        themeToggleBtn.click(function() {
            body.toggleClass('dark');
            if (body.hasClass('dark')) {
                localStorage.theme = 'dark';
                $("#svg").empty();
                $("#svg").append(`
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>

            `);
            } else {
                localStorage.theme = 'light';
                $("#svg").empty();
                $("#svg").append(` 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>`);


            }
        });


    })
</script>
