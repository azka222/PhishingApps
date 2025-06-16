@php
    $url = explode('/course/', Route::current()->uri)[0];
    $home = $user = $landingPage = $attribute = $dashboard = $approval = $campaign = $admin = false;
    switch ($url) {
        case 'course/dashboard':
            $dashboard = true;
            break;
        case 'course/lists':
            $user = true;
            break;
    }
@endphp
<nav class="border-b-2 p-4 border-b-gray-100 bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-800 items-center"
    id="navbar-header">
    <div class="max-w-full flex flex-wrap items-center justify-between mx-4">
        <a href="{{ url('/course/lists') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('image/kittyoEat.png') }}" class="md:h-12 h-8" alt="Flowbite Logo" />
            <span class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap dark:text-white">Fischsim</span>
        </a>
        <div class="flex flex-row items-center gap-2 lg:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

            <div class="flex flex-col items-center">
                <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                    class="flex items-center text-sm font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:me-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white"
                    type="button">
                    <img class="md:h-12 h-9 rounded-full" src="{{ Avatar::create($name)->toBase64() }}"
                        alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownAvatarName"
                    class="z-10 hidden absolute mt-10 me-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="text-sm text-gray-900 px-2 pt-2 dark:text-white">
                        <div class="font-medium ">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                        <div class="truncate text-xs pb-2">{{ Auth::user()->email }}</div>
                    </div>
                    <ul class=" text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                        <li>
                            <div class="flex items-center justify-between p-2">
                                <span class="">Dark Mode
                                </span>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" class="sr-only peer" id="theme-toggle">
                                    <div
                                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                    </div>

                                </label>
                            </div>
                        </li>
                    </ul>
                    <div class="">
                        <a href="{{ route('employeeLogout') }}"
                            class="block p-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
                            out</a>
                    </div>

                </div>
            </div>
            <button data-collapse-toggle="navbar-menu" id="toggle-navbar" type="button" onclick="handleClickMenu()"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div id="targetEl"
            class="lg:border-0 border-2 rounded-lg border-gray-50 dark:border-gray-700 items-center justify-between hidden w-full lg:flex mt-4 lg:mt-0 px-8 py-4 lg:py-0 lg:w-auto lg:order-1"
            data-collapse-target="navbar-menu">

            <div class="items-center justify-between lg:flex gap-4 lg:w-auto lg:order-1"
                data-collapse-target="navbar-menu">
        
                @CanAccessCourse()
                <div class="flex justify-end">
                    <button
                        class="w-full px-3 py-1 text-xs font-medium text-left hover:text-blue-600 dark:hover:text-blue-500 rounded-xl
                               {{ $user ? 'dark:text-blue-500 text-blue-500  shadow-blue-500/50 lg:dark:bg-gray-800 dark:bg-gray-800' : 'border-gray-700 text-gray-900 dark:text-white ' }} 
                               rounded-xl "
                        type="button">
                        <a href="{{ url('course/lists') }}">Course</a>
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" class="inline w-7 h-7"
                            viewBox="0 0 500 500" style="enable-background:new 0 0 500 500" xml:space="preserve">
                            <style>
                                .st0 {
                                    fill: #ecf4f7
                                }

                                .st1 {
                                    fill: #1c1d21
                                }

                                .st3 {
                                    fill: #aab1ba
                                }
                            </style>
                            <path class="st0"
                                d="M250 297.4h20c11.1 0 21.6-4.6 29.2-12.7 6.9-7.4 10.7-17.1 10.7-27.2v-79.4c0-62.8-21.1-123.8-59.9-173.2-38.8 49.4-59.9 110.4-59.9 173.2v79.4c0 10.1 3.8 19.8 10.7 27.2 7.5 8.1 18.1 12.7 29.2 12.7h20M250 297.4h8c8.8 0 17.2 3.5 23.5 9.7 6.2 6.2 9.7 14.7 9.7 23.5v35.3h-82.4v-35.3c0-8.8 3.5-17.2 9.7-23.5 6.2-6.2 14.7-9.7 23.5-9.7h8" />
                            <path
                                d="M271.6 365.9v4.4c0 19-5.5 37.5-15.8 53.5l-5.8 9-5.8-9a98.453 98.453 0 0 1-15.8-53.5v-4.4h43.2z"
                                style="fill:#fddf7f" />
                            <path class="st1"
                                d="M270 302.4h-40c-12.4 0-24.4-5.2-32.8-14.3-7.8-8.3-12.1-19.2-12.1-30.6v-79.4c0-63.6 21.6-126.2 61-176.2C247 .7 248.5 0 250 0c.5 0 1 .1 1.5.2 1 .3 1.9.9 2.5 1.7 39.3 50 61 112.6 61 176.2v79.4c0 11.4-4.3 22.3-12.1 30.6-8.5 9.1-20.5 14.3-32.9 14.3zM250 13.2c-35.5 47.4-54.9 105.7-54.9 165v79.4c0 8.9 3.3 17.3 9.4 23.8 6.6 7 15.9 11.1 25.5 11.1h40c9.6 0 18.9-4 25.5-11.1 6-6.5 9.4-14.9 9.4-23.8v-79.4c0-59.3-19.4-117.6-54.9-165z" />
                            <path class="st1"
                                d="M291.2 370.9h-82.5c-2.8 0-5-2.2-5-5v-35.3c0-10.2 4-19.8 11.2-27 7.2-7.2 16.8-11.2 27-11.2h16c10.2 0 19.8 4 27 11.2 7.2 7.2 11.2 16.8 11.2 27v35.3c.1 2.7-2.1 5-4.9 5zm-77.4-10h72.5v-30.3c0-7.5-2.9-14.6-8.3-19.9-5.3-5.3-12.4-8.3-19.9-8.3h-16c-7.5 0-14.6 2.9-19.9 8.3-5.3 5.3-8.3 12.4-8.3 19.9v30.3z" />
                            <circle cx="250" cy="108.6" r="21.6" style="fill:#83e1e5" />
                            <path class="st1"
                                d="M250 135.2c-14.7 0-26.6-11.9-26.6-26.6S235.4 82 250 82c14.7 0 26.6 11.9 26.6 26.6s-11.9 26.6-26.6 26.6zm0-43.2c-9.1 0-16.6 7.4-16.6 16.6 0 9.1 7.4 16.6 16.6 16.6 9.1 0 16.6-7.4 16.6-16.6 0-9.1-7.4-16.6-16.6-16.6zM250 437.8c-1.8 0-3.5-1-4.4-2.5l-5.7-8.8c-10.8-16.8-16.6-36.2-16.6-56.2v-4.4c0-2.8 2.2-5 5-5h43.1c2.8 0 5 2.2 5 5v4.4c0 20-5.7 39.4-16.6 56.2l-5.6 8.7c-.7 1.6-2.3 2.6-4.2 2.6zm-16.6-66.9c.1 17.8 5.3 35.2 15 50.2l1.6 2.5 1.6-2.5c9.7-15 14.8-32.3 15-50.2h-33.2z" />
                            <path class="st1"
                                d="M250 457.2c-2.8 0-5-2.2-5-5v-19.4c0-2.8 2.2-5 5-5s5 2.2 5 5v19.4c0 2.8-2.2 5-5 5zM250 483.6c-2.8 0-5-2.2-5-5v-9.1c0-2.8 2.2-5 5-5s5 2.2 5 5v9.1c0 2.8-2.2 5-5 5zM250 500c-1.3 0-2.6-.5-3.5-1.5-.9-.9-1.5-2.2-1.5-3.5 0-1.3.5-2.6 1.5-3.5.9-.9 2.2-1.5 3.5-1.5 1.3 0 2.6.5 3.5 1.5.9.9 1.5 2.2 1.5 3.5 0 1.3-.5 2.6-1.5 3.5-.9 1-2.2 1.5-3.5 1.5z" />
                            <path class="st3"
                                d="M190.1 164.6 160 198.3c-13.7 15.4-21.3 35.2-21.3 55.8v37.3l51.3-49v-77.8zM309.9 164.6l30.1 33.7c13.7 15.4 21.3 35.2 21.3 55.8v37.3l-51.3-49v-77.8z" />
                            <path class="st1"
                                d="M138.8 296.5c-.7 0-1.3-.1-2-.4-1.8-.8-3-2.6-3-4.6v-37.3c0-21.8 8-42.8 22.5-59.1l30.1-33.7c1.4-1.5 3.6-2.1 5.5-1.3 1.9.7 3.2 2.6 3.2 4.7v77.9c0 1.4-.6 2.7-1.5 3.6l-51.3 49c-1 .7-2.3 1.2-3.5 1.2zm46.3-118.8-21.3 23.9c-12.9 14.5-20 33.1-20 52.5v25.7l41.3-39.5v-62.6zM361.3 296.5c-1.3 0-2.5-.5-3.5-1.4l-51.3-49c-1-.9-1.5-2.3-1.5-3.6v-77.9c0-2.1 1.3-3.9 3.2-4.7 1.9-.7 4.1-.2 5.5 1.3l30.1 33.7c14.5 16.3 22.5 37.3 22.5 59.1v37.3c0 2-1.2 3.8-3 4.6-.7.4-1.4.6-2 .6zm-46.4-56.2 41.3 39.5v-25.7c0-19.4-7.1-38-20-52.5l-21.3-23.9v62.6zM291.2 347h-82.5c-2.8 0-5-2.2-5-5s2.2-5 5-5h82.5c2.8 0 5 2.2 5 5s-2.2 5-5 5z" />
                        </svg>
                    </button>
                </div>
                @endCanAccessCourse()
            </div>




        </div>
    </div>
</nav>

<script>
    function handleClickMenu() {
        $("#targetEl").toggleClass('hidden');
    }
    $(document).ready(function() {

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
        const darkMode = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
            '(prefers-color-scheme: dark)').matches);
        if (darkMode) {
            $("#theme-toggle").prop('checked', true);
            localStorage.theme === 'dark'
            body.addClass('dark');
            $("#svg").append(`
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:h-5 md:w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>

            `);

        } else {
            localStorage.theme === 'light'
            $("#theme-toggle").prop('checked', false);
            body.removeClass('dark');
            $("#svg").append(`
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 md:h-5 md:w-5">
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
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:h-5 md:w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>

            `);
            } else {
                localStorage.theme = 'light';
                $("#svg").empty();
                $("#svg").append(`
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 md:h-5 md:w-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>`);
            }
        });


    })
</script>
