@php
    $url = explode('/', Route::current()->uri)[0];
    $home = $user = $landingPage = $attribute = $dashboard = $campaign = $admin = false;
    switch ($url) {
        case 'dashboard':
            $dashboard = true;
            break;
        case 'target':
            $user = true;
            break;
        case 'groups':
            $user = true;
            break;
        case 'landing-page':
            $attribute = true;
            break;
        case 'email-templates':
            $attribute = true;
            break;
        case 'sending-profile':
            $attribute = true;
            break;
        case 'campaigns':
            $campaign = true;
            break;
        case 'admin':
            $admin = true;
            break;
        default:
            $home = true;
            break;
    }

@endphp
<nav class="border-b-2 p-4 border-b-gray-100 bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-800 items-center"
    id="navbar-header">
    <div class="max-w-full flex flex-wrap items-center justify-between mx-4">
        <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('image/kittyoEat.png') }}" class="md:h-12 h-8" alt="Flowbite Logo" />
            <span class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap dark:text-white">Fischsim</span>
        </a>
        <div class="flex flex-row items-center gap-2 lg:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button id="theme-toggle"
                class="px-4 py-2 md:me-4 me-0 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 dark:bg-yellow-500 dark:hover:bg-yellow-600">
                <div id="svg">
                </div>
            </button>
            <div class="flex flex-col items-center">
                <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                    class="flex items-center text-sm font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:me-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white"
                    type="button">
                    <img class="md:h-12 h-9 rounded-full" src="{{ asset('/image/user.png') }}" alt="user photo">
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownAvatarName"
                    class="z-10 hidden absolute mt-10 me-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="text-sm text-gray-900 px-2 pt-2 dark:text-white">
                        <div class="font-medium ">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</div>
                        <div class="truncate text-xs pb-2">{{ Auth::user()->email }}</div>
                    </div>
                    <ul class="py-2 px-2 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                        <li>
                            <a href="{{ route('userSettingView') }}"
                                class="block py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                        </li>
                    </ul>
                    <div class="py-2 px-2">
                        <a href="{{ route('logout') }}"
                            class="block py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign
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
                @CanAccessDashboard()
                <div class="flex justify-end">
                    <button
                        class="w-full px-3 py-2 text-xs font-medium text-left 
                               {{ $dashboard ? 'border-2 dark:text-white text-black border-blue-500 shadow-blue-500/50 lg:dark:bg-gray-800 dark:bg-gray-800 dark:border-blue-500' : 'border-gray-700 text-gray-900 dark:text-white ' }} 
                               rounded-xl "
                        type="button">
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5 ms-1 inline">
                            <defs>
                                <style>
                                    .cls-1 {
                                        fill: #7c7d7d
                                    }

                                    .cls-2 {
                                        fill: #919191
                                    }

                                    .cls-3 {
                                        fill: #dad7e5
                                    }

                                    .cls-4 {
                                        fill: #edebf2
                                    }

                                    .cls-7 {
                                        fill: #c6c3d8
                                    }

                                    .cls-9 {
                                        fill: #fc6
                                    }

                                    .cls-10 {
                                        fill: #ffde76
                                    }
                                </style>
                            </defs>
                            <g id="Dashboard">
                                <path class="cls-1" d="M6 31h36v16H6z" />
                                <path class="cls-2" d="M42 31v14H11a3 3 0 0 1-3-3V31z" />
                                <path class="cls-3" d="M18 36v3h-6v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1z" />
                                <path class="cls-4" d="M18 36v1h-2a2 2 0 0 1-2-2h3a1 1 0 0 1 1 1z" />
                                <path class="cls-3" d="M18 39v3a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1v-3z" />
                                <path class="cls-4"
                                    d="M18 39v2h-3a1 1 0 0 1-1-1v-1zM38 40h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2zM38 44h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2zM32 40h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2zM32 44h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2zM26 40h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2zM26 44h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2zM38 36h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2zM32 36h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2zM26 36h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2z" />
                                <path class="cls-1" d="M6 1h36v30H6z" />
                                <path class="cls-2" d="M42 1v28H11a3 3 0 0 1-3-3V1z" />
                                <path style="fill:#9fdbf3" d="M10 5h14v10H10z" />
                                <path d="M24 5v8h-9a3 3 0 0 1-3-3V5z" style="fill:#b2e5fb" />
                                <path class="cls-4" d="M29 15V5a1 1 0 0 1 2 0v10a1 1 0 0 1-2 0z" />
                                <path class="cls-7" d="M31 14h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2z" />
                                <path class="cls-4" d="M35 15V5a1 1 0 0 1 2 0v10a1 1 0 0 1-2 0z" />
                                <path class="cls-7" d="M37 10h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2z" />
                                <path
                                    d="M24 9.5v2c-2.08 0-2.17-1.7-3.62-.69a3.17 3.17 0 0 1-4 0 1.2 1.2 0 0 0-1.63 0 3.16 3.16 0 0 1-4 0 1.18 1.18 0 0 0-.75-.31v-2c1.67 0 1.93 1 2.8 1s1.15-1 2.8-1 1.94 1 2.79 1 1.15-1 2.81-1 1.94 1 2.8 1z"
                                    style="fill:#8bd1ea" />
                                <path class="cls-9" d="M14 23a2 2 0 1 1-2.82-1.82A2 2 0 0 1 14 23z" />
                                <path class="cls-10" d="M13.82 23.82a2 2 0 0 1-2.64-2.64 2 2 0 0 1 2.64 2.64z" />
                                <circle class="cls-9" cx="20" cy="23" r="2" />
                                <circle class="cls-9" cx="28" cy="23" r="2" />
                                <circle class="cls-9" cx="36" cy="23" r="2" />
                                <path class="cls-10"
                                    d="M21.82 23.82a2 2 0 0 1-2.64-2.64 2 2 0 0 1 2.64 2.64zM29.82 23.82a2 2 0 0 1-2.64-2.64 2 2 0 0 1 2.64 2.64zM37.82 23.82a2 2 0 0 1-2.64-2.64 2 2 0 0 1 2.64 2.64z" />
                            </g>
                        </svg>
                    </button>
                </div>


                @endCanAccessDashboard()
                @CanAccessTargetGroup()
                <div class="flex justify-end">
                    <button id="dropdownHoverButton" data-dropdown-toggle="hoverTargetGroup"
                        data-dropdown-trigger="click"
                        class="w-full px-3 py-1 text-xs font-medium text-left 
                               {{ $user ? 'border-2 dark:text-white text-black border-blue-500 shadow-blue-500/50 lg:dark:bg-gray-800 dark:bg-gray-800 dark:border-blue-500' : 'border-gray-700 text-gray-900 dark:text-white ' }} 
                               rounded-xl "
                        type="button">
                        <span>Target</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 80" class="inline ms-2 w-7 h-7"
                            xml:space="preserve">
                            <path fill="#667BBC"
                                d="m6.266 52.449 2.667-3.667 4.167-.5.5-2.667 5-.333 1.333 3.167 4.833.667 1.333 1.667 4.833-3 5.333-.5.333-4.333 7.333.667.333 4s5 0 6.667 1.333 2.333 1.667 2.333 1.667l2.5-1.5 4.667-.667.667-3 4.667-.5.5 2.833 5.833 1.833 1.333 4s.501 1-5.666 3-13.5-1.167-13.5-1.167.167 2-8.833 3.333-19.833-3.667-19.833-3.667 1 2.167-6.833 2.167-12.5-4.833-12.5-4.833z" />
                            <path fill="#FFCC43"
                                d="M41.808 21.616c-4.764 0-8.625 4.533-8.625 10.125s3.861 10.125 8.625 10.125c4.764 0 8.625-4.533 8.625-10.125s-3.862-10.125-8.625-10.125zm23.03 8.166c-3.274 0-5.928 3.115-5.928 6.958s2.654 6.958 5.928 6.958c3.273 0 5.927-3.115 5.927-6.958.001-3.842-2.653-6.958-5.927-6.958zm-47 0c-3.274 0-5.928 3.115-5.928 6.958s2.654 6.958 5.928 6.958 5.927-3.115 5.927-6.958c.001-3.842-2.653-6.958-5.927-6.958z" />
                            <path fill="#131731"
                                d="M76.106 53.144a46.112 46.112 0 0 0-1.27-2.09c-.762-1.118-1.455-2.253-2.486-3.004-1.163-.699-2.411-.769-3.648-.924a25.268 25.268 0 0 0-.764-.063v-1.585c2.932-1.869 4.824-5.458 4.83-9.433-.009-5.781-4.007-10.747-9.397-10.789-5.389.042-9.385 5.008-9.396 10.789.007 4.002 1.927 7.609 4.893 9.468v1.55c-.24.017-.498.037-.764.063-1.238.156-2.485.225-3.647.925a5.75 5.75 0 0 0-1.088 1.047c-.513-.663-1.054-1.252-1.654-1.683-1.357-.827-3.042-.968-4.669-1.161a37.95 37.95 0 0 0-1.498-.113v-2.918c3.916-2.367 6.492-7.091 6.501-12.392-.013-7.555-5.23-13.957-12.126-14.001-6.896.044-12.113 6.446-12.126 14.001.009 5.337 2.623 10.087 6.583 12.438v2.871c-.444.025-.957.062-1.498.113-1.627.193-3.312.334-4.667 1.161-.626.448-1.187 1.069-1.719 1.766-.336-.421-.692-.804-1.149-1.129-1.165-.699-2.409-.771-3.647-.927a33.267 33.267 0 0 0-.763-.062v-1.586c2.932-1.869 4.823-5.457 4.829-9.432-.009-5.781-4.007-10.747-9.396-10.789-5.389.042-9.385 5.008-9.396 10.789.008 4.002 1.927 7.609 4.894 9.468v1.55c-.24.017-.498.037-.764.063-1.236.155-2.484.225-3.647.924-1.032.751-1.725 1.886-2.487 3.004a46.112 46.112 0 0 0-1.27 2.09l-1.022 1.81 2.041.4c1.363.254 2.384.987 4.193 1.848 1.597.75 3.713 1.423 6.872 1.558v.03l.249.001c.215 0 .418-.006.625-.01.096.001.183.007.281.007h.084v-.013c4.482-.145 6.782-1.265 8.359-2.197 1.48.485 2.787 1.331 4.726 2.247 2.096.983 4.847 1.866 9.026 2.049v.042h.059c.38 0 .747-.005 1.105-.014.149.002.283.011.435.011h.067v-.027c4.689-.167 7.485-1.056 9.516-2.078 1.875-.956 2.934-1.781 4.318-2.248 1.707.91 4.065 2.022 8.15 2.193v.037h.077c.21 0 .397-.01.599-.014.132.002.248.014.384.014l.18-.001v-.024c3.529-.124 5.688-.797 7.243-1.581 1.753-.899 2.498-1.584 3.821-1.829l2.041-.4-1.023-1.81zM56.977 36.046c-.002-2.219.768-4.203 1.956-5.597 1.193-1.396 2.748-2.191 4.439-2.193 1.693.002 3.247.797 4.441 2.193 1.188 1.394 1.958 3.378 1.956 5.597.002 2.221-.768 4.203-1.956 5.598-1.195 1.398-2.748 2.192-4.441 2.192-1.691 0-3.246-.795-4.439-2.192-1.188-1.395-1.958-3.378-1.956-5.598zm-23.424 2.653c-1.68-1.976-2.756-4.763-2.754-7.868-.003-3.105 1.074-5.893 2.754-7.868 1.688-1.978 3.926-3.13 6.371-3.133 2.445.003 4.683 1.155 6.371 3.133 1.68 1.976 2.754 4.763 2.754 7.868 0 3.105-1.074 5.893-2.754 7.868-1.689 1.977-3.926 3.13-6.371 3.132-2.445-.002-4.682-1.155-6.371-3.132zM9.977 36.046c-.002-2.219.768-4.203 1.954-5.597 1.195-1.396 2.75-2.191 4.441-2.193 1.693.002 3.246.797 4.441 2.193 1.186 1.394 1.958 3.378 1.956 5.597.002 2.221-.77 4.203-1.956 5.598-1.195 1.398-2.747 2.192-4.441 2.192-1.691 0-3.247-.795-4.441-2.192-1.186-1.395-1.956-3.378-1.954-5.598zM7.27 53.031c.071-.113.145-.229.221-.346.602-.984 1.548-2.143 1.631-2.137 0-.005.051-.031.187-.076.495-.176 1.587-.332 2.473-.394.898-.071 1.609-.083 1.611-.085l1.475-.022v-3.293c.489.092.987.154 1.504.158a8.485 8.485 0 0 0 1.566-.169v3.303l1.476.024c.003 0 .94.016 2.001.115.53.052 1.086.125 1.532.219.221.044.414.098.55.145.136.042.185.078.187.076.024-.019.576.574 1.029 1.238-.792 1.255-1.377 2.292-1.387 2.306l-.156.277c-1.324.708-2.961 1.313-6.742 1.406-3.122-.076-4.84-.647-6.247-1.295-.961-.434-1.84-.994-2.911-1.45zm41.705 3.093c-1.743.861-4.083 1.666-8.797 1.776-4.384-.082-6.833-.887-8.804-1.794-1.503-.687-2.812-1.546-4.464-2.173.192-.312.405-.65.629-.996.838-1.349 2.068-2.901 2.344-3.024.145-.174 1.876-.575 3.289-.673 1.453-.139 2.733-.158 2.734-.16l1.476-.022v-4.543c.816.201 1.665.312 2.542.317a10.923 10.923 0 0 0 2.626-.342v4.567l1.477.022c.002 0 1.281.021 2.732.16 1.415.098 3.146.499 3.291.673.274.123 1.504 1.676 2.342 3.024.229.353.445.697.641 1.016-1.577.641-2.709 1.517-4.058 2.172zm20.953-1.625c-1.271.625-2.988 1.211-6.569 1.277-3.457-.1-5.149-.771-6.671-1.536l-.083-.146a59.013 59.013 0 0 0-1.447-2.398c.454-.632.931-1.162.962-1.146a.89.89 0 0 1 .189-.076c.492-.176 1.585-.329 2.474-.395.895-.07 1.607-.082 1.607-.084l1.478-.022v-3.292c.488.091.986.153 1.502.157a8.42 8.42 0 0 0 1.568-.17v3.305l1.475.022c.002 0 .94.016 2.003.118.528.051 1.085.125 1.531.216.22.047.414.098.55.145.136.045.183.081.187.076.08-.007 1.029 1.152 1.631 2.137.081.125.16.249.236.37-1.009.467-1.776 1.034-2.623 1.442z" />
                        </svg>
                    </button>
                </div>

                <div id="hoverTargetGroup"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                        @CanAccess('Target', 'read')
                        <li>
                            <a href="{{ url('/target') }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Target</a>
                        </li>
                        @endCanAccess()
                        @CanAccess('Group', 'read')
                        <li>
                            <a href="{{ url('/groups') }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Groups</a>
                        </li>
                        @endCanAccess()
                    </ul>
                </div>
                @endCanAccessTargetGroup()
                @CanAccessAttribute()
                <div class="flex justify-end">
                    <button id="dropdownHoverButton2" data-dropdown-toggle="hoverAttribute"
                        data-dropdown-trigger="click"
                        class="w-full px-3 py-2 text-xs font-medium text-left  {{ $attribute ? 'border-2 dark:text-white text-black border-blue-500 shadow-blue-500/50 lg:dark:bg-gray-800 dark:bg-gray-800 dark:border-blue-500' : 'border-gray-700 text-gray-900 dark:text-white ' }} rounded-xl "
                        type="button">
                        <span>Attribute</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            class="inline ms-2 w-4 h-4 mb-1" style="enable-background:new 0 0 512 512"
                            xml:space="preserve">
                            <path style="fill:#ffc36e"
                                d="M469.789 153.386H42.232c-18.891 0-34.205 15.314-34.205 34.205v273.637c0 18.891 15.314 34.205 34.205 34.205h427.557c18.891 0 34.205-15.314 34.205-34.205V187.591c0-18.891-15.313-34.205-34.205-34.205z" />
                            <path style="fill:#ffb464"
                                d="M503.908 185.287c-.589-8.847-4.539-16.769-10.587-22.508.062.088.124.176.193.244L313.508 324.409H198.515L18.507 163.023c.045-.044.077-.113.115-.169-6.004 5.732-9.923 13.624-10.509 22.433l177.691 159.309-162.09 145.323c5.344 3.456 11.681 5.513 18.519 5.513H469.79c6.838 0 13.174-2.057 18.518-5.512l-162.09-145.322 177.69-159.311z" />
                            <path style="fill:#ffd782"
                                d="M469.789 153.386H42.232c-9.23 0-17.572 3.695-23.725 9.637L221.29 344.829c19.757 17.714 49.682 17.714 69.441 0l202.783-181.806c-6.152-5.942-14.494-9.637-23.725-9.637z" />
                            <path style="fill:#ffc36e"
                                d="M129.881 153.386h-16.773c8.885 71.087 69.409 126.129 142.903 126.129s134.019-55.043 142.903-126.129H129.881z" />
                            <circle style="fill:#eff2fa" cx="256.011" cy="136.284" r="119.716" />
                            <path style="fill:#afb9d2"
                                d="M330.999 119.182h-17.641c-2.709-9.094-7.532-17.255-13.884-23.973l8.842-15.315c-4.144-3.838-8.728-7.317-13.825-10.26-5.098-2.944-10.401-5.172-15.797-6.842L269.855 78.1c-4.451-1.056-9.071-1.674-13.844-1.674-4.774 0-9.393.618-13.844 1.674l-8.839-15.308c-5.396 1.67-10.7 3.899-15.797 6.842s-9.681 6.422-13.825 10.26l8.842 15.315c-6.35 6.718-11.175 14.879-13.884 23.973h-17.641c-1.252 5.508-1.973 11.216-1.973 17.102 0 5.886.721 11.594 1.973 17.102h17.641c2.709 9.094 7.532 17.255 13.884 23.972l-8.842 15.315c4.144 3.837 8.728 7.317 13.825 10.259s10.401 5.172 15.797 6.843l8.839-15.308c4.451 1.056 9.071 1.674 13.844 1.674 4.774 0 9.393-.618 13.844-1.674l8.839 15.308c5.396-1.671 10.7-3.899 15.797-6.843 5.098-2.944 9.681-6.422 13.825-10.259l-8.842-15.315c6.351-6.718 11.175-14.878 13.884-23.973h17.641c1.252-5.508 1.973-11.216 1.973-17.102s-.722-11.593-1.973-17.101zm-74.988 42.755c-14.168 0-25.653-11.485-25.653-25.653s11.485-25.653 25.653-25.653 25.653 11.485 25.653 25.653-11.485 25.653-25.653 25.653z" />
                            <path style="fill:#c7cfe2"
                                d="M256.011 84.443c-28.631 0-51.841 23.21-51.841 51.841s23.21 51.841 51.841 51.841 51.841-23.21 51.841-51.841-23.21-51.841-51.841-51.841zm0 77.494c-14.168 0-25.653-11.485-25.653-25.653s11.485-25.653 25.653-25.653 25.653 11.485 25.653 25.653-11.485 25.653-25.653 25.653z" />
                            <path
                                d="M469.779 145.37h-86.373c.212-3.003.327-6.031.327-9.086 0-70.433-57.3-127.733-127.733-127.733s-127.733 57.3-127.733 127.733c0 3.055.114 6.083.327 9.086H42.221C18.941 145.37 0 164.31 0 187.591v273.637c0 23.28 18.941 42.221 42.221 42.221h427.557c23.28 0 42.221-18.941 42.221-42.221V187.591c.001-23.281-18.94-42.221-42.22-42.221zM256 24.585c61.592 0 111.699 50.108 111.699 111.699S317.592 247.983 256 247.983s-111.699-50.108-111.699-111.699S194.408 24.585 256 24.585zM130.753 161.403c11.702 58.444 63.41 102.614 125.247 102.614s113.544-44.17 125.247-102.614h88.532c3.808 0 7.427.824 10.695 2.293L284.898 339.04c-16.474 14.77-41.321 14.771-57.796 0L31.525 163.697a26.01 26.01 0 0 1 10.696-2.294h88.532zm-114.72 26.188c0-4.767 1.287-9.237 3.522-13.093l171.977 154.187L23.408 479.417c-4.56-4.715-7.374-11.128-7.374-18.189V187.591zm26.188 299.824c-1.172 0-2.323-.086-3.454-.235l164.774-147.729 12.857 11.527c11.289 10.12 25.445 15.18 39.601 15.18 14.156 0 28.313-5.06 39.6-15.18l12.857-11.527L473.232 487.18c-1.131.15-2.282.235-3.454.235H42.221zm453.746-26.187c0 7.062-2.814 13.474-7.374 18.19L320.467 328.685l171.977-154.187a26.02 26.02 0 0 1 3.522 13.093l.001 273.637z" />
                            <path
                                d="M192.967 161.403a68.324 68.324 0 0 0 9.78 16.878l-5.995 10.385a8.016 8.016 0 0 0 1.495 9.89c4.772 4.419 9.908 8.227 15.264 11.32 5.355 3.092 11.222 5.635 17.436 7.558a8.015 8.015 0 0 0 9.313-3.65l5.986-10.366a64.834 64.834 0 0 0 19.509 0l5.986 10.366a8.018 8.018 0 0 0 9.314 3.65c6.213-1.923 12.08-4.466 17.436-7.558 5.356-3.092 10.491-6.901 15.264-11.32a8.016 8.016 0 0 0 1.495-9.89l-5.995-10.384a68.306 68.306 0 0 0 9.78-16.878h11.956a8.016 8.016 0 0 0 7.817-6.24c1.442-6.343 2.172-12.694 2.172-18.879s-.731-12.536-2.172-18.879a8.017 8.017 0 0 0-7.817-6.24h-11.958a68.337 68.337 0 0 0-9.78-16.878l5.995-10.384a8.014 8.014 0 0 0-1.495-9.889c-4.772-4.419-9.906-8.228-15.264-11.321-5.356-3.093-11.223-5.635-17.436-7.558a8.016 8.016 0 0 0-9.312 3.65l-5.986 10.366a64.834 64.834 0 0 0-19.509 0l-5.986-10.366a8.02 8.02 0 0 0-9.312-3.65c-6.213 1.923-12.08 4.466-17.436 7.558-5.357 3.093-10.492 6.902-15.264 11.321a8.015 8.015 0 0 0-1.495 9.889l5.995 10.385a68.306 68.306 0 0 0-9.78 16.878h-11.956a8.016 8.016 0 0 0-7.817 6.24c-1.441 6.341-2.172 12.692-2.172 18.877 0 6.185.731 12.536 2.172 18.879a8.017 8.017 0 0 0 7.817 6.24h11.955zm-5.276-34.205h10.963a8.017 8.017 0 0 0 7.683-5.728c2.285-7.674 6.444-14.85 12.026-20.755a8.017 8.017 0 0 0 1.117-9.515l-5.503-9.531a66.806 66.806 0 0 1 7.551-5.092 66.665 66.665 0 0 1 8.186-3.993l5.499 9.525a8.015 8.015 0 0 0 8.793 3.791c4.077-.967 8.112-1.457 11.994-1.457 3.882 0 7.917.49 11.994 1.457a8.017 8.017 0 0 0 8.793-3.791l5.499-9.525a66.665 66.665 0 0 1 8.186 3.993 66.896 66.896 0 0 1 7.551 5.092L292.52 91.2a8.018 8.018 0 0 0 1.117 9.516c5.582 5.904 9.74 13.08 12.025 20.754a8.018 8.018 0 0 0 7.683 5.728h10.963c.422 3.068.635 6.106.635 9.086s-.213 6.018-.635 9.086h-10.961a8.017 8.017 0 0 0-7.683 5.728c-2.285 7.674-6.443 14.85-12.025 20.754a8.016 8.016 0 0 0-1.117 9.516l5.503 9.531a66.896 66.896 0 0 1-7.551 5.092 66.665 66.665 0 0 1-8.186 3.993l-5.499-9.524a8.017 8.017 0 0 0-8.792-3.791c-4.077.967-8.112 1.457-11.994 1.457-3.882 0-7.917-.49-11.994-1.457a8.012 8.012 0 0 0-8.793 3.791l-5.499 9.524a66.665 66.665 0 0 1-8.186-3.993 66.806 66.806 0 0 1-7.551-5.092l5.503-9.531a8.018 8.018 0 0 0-1.117-9.516c-5.582-5.903-9.74-13.08-12.025-20.754a8.018 8.018 0 0 0-7.683-5.728h-10.963a66.731 66.731 0 0 1-.635-9.086 66.56 66.56 0 0 1 .631-9.086z" />
                            <path
                                d="M256 169.954c18.566 0 33.67-15.105 33.67-33.67 0-18.566-15.105-33.67-33.67-33.67s-33.67 15.105-33.67 33.67c0 18.566 15.104 33.67 33.67 33.67zm0-51.307c9.725 0 17.637 7.912 17.637 17.637s-7.912 17.637-17.637 17.637-17.637-7.912-17.637-17.637c0-9.725 7.912-17.637 17.637-17.637z" />
                        </svg>

                    </button>
                </div>
                <div id="hoverAttribute"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton2">
                        <li>
                            <a href="{{ url('/sending-profile') }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sending
                                Profile</a>
                        </li>
                        <li>
                            <a href="{{ url('/email-templates') }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Email
                                Template</a>
                        </li>
                        <li>
                            <a href="{{ url('/landing-page') }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Landing
                                Page</a>
                        </li>
                    </ul>
                </div>
                @endCanAccessAttribute()
                @CanAccess('Campaign', 'read')

                <div class="flex justify-end">
                    <button
                        class="w-full px-3 py-1 text-xs font-medium text-left 
                               {{ $campaign ? 'border-2 dark:text-white text-black border-blue-500 shadow-blue-500/50 lg:dark:bg-gray-800 dark:bg-gray-800 dark:border-blue-500' : 'border-gray-700 text-gray-900 dark:text-white ' }} 
                               rounded-xl "
                        type="button">
                        <a href="{{ url('/campaigns') }}">Campaign</a>
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
                @endCanAccess()
                @IsAdmin()
                <div>
                    <button id="dropdownHoverButton3" data-dropdown-toggle="hoverAdminGroup"
                        data-dropdown-trigger="click"
                        class="w-full px-3 py-2 text-xs font-medium text-left  {{ $admin ? 'border-2 dark:text-white text-black border-blue-500 shadow-blue-500/50 lg:dark:bg-gray-800 dark:bg-gray-800 dark:border-blue-500' : 'border-gray-700 text-gray-900 dark:text-white ' }} rounded-xl "
                        type="button">Admin
                    </button>
                </div>
                <div id="hoverAdminGroup"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton3">
                        <li>
                            <a href="{{ route('adminUserView') }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">User</a>
                        </li>
                        <li>
                            <a href="{{ route('adminCompanyView') }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Company</a>
                        </li>
                    </ul>
                </div>
                @endIsAdmin()
            </div>

            <div class="fixed top-16 right-4 z-50 flex flex-col gap-2 bg-white dark:bg-gray-800 rounded-md shadow-lg p-4 w-64 hidden"
                id="mobileDropdown">
                <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-900 dark:text-white">
                    Dashboard
                </a>
                <a href="{{ url('/target') }}" class="block px-4 py-2 text-sm text-gray-900 dark:text-white">
                    Target
                </a>
                <a href="{{ url('/groups') }}" class="block px-4 py-2 text-sm text-gray-900 dark:text-white">
                    Groups
                </a>
                <a href="{{ url('/sending-profile') }}"
                    class="block px-4 py-2 text-sm text-gray-900 dark:text-white">
                    Sending Profile
                </a>
                <a href="{{ url('/email-templates') }}"
                    class="block px-4 py-2 text-sm text-gray-900 dark:text-white">
                    Email Template
                </a>
                <a href="{{ url('/landing-page') }}" class="block px-4 py-2 text-sm text-gray-900 dark:text-white">
                    Landing Page
                </a>
                <a href="{{ url('/campaigns') }}" class="block px-4 py-2 text-sm text-gray-900 dark:text-white">
                    Campaign
                </a>
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
        if (localStorage.theme === 'dark') {
            body.addClass('dark');
            $("#svg").append(`
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:h-5 md:w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                </svg>

            `);

        } else {
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
