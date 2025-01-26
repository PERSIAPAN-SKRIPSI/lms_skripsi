<nav x-data="{ open: false }" class="bg-white shadow-md z-10 sticky top-0">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <!-- Logo -->
                <div class="shrink-0 flex items-center mr-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center group mr-4">
                        <!-- Added mr-4 to the <a> tag -->
                        <x-application-logo
                            class="block h-9 w-auto transition-transform duration-300 transform-gpu group-hover:scale-110 filter drop-shadow-md" />
                        <span class="ml-2 text-2xl font-semibold text-gray-800 tracking-tight">EduPlatform</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 px-3 py-2  rounded-md transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @role('admin')
                        <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories*')"
                            class="font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 px-3 py-2 rounded-md transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                            {{ __('Categories') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.teachers.index')" :active="request()->routeIs('admin.teachers*')"
                            class="font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 px-3 py-2 rounded-md transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                            {{ __('Teachers') }}
                        </x-nav-link>
                    @endrole

                    @role('admin|teacher')
                        <x-nav-link :href="route('admin.courses.index')" :active="request()->routeIs('admin.courses*') || request()->routeIs('admin.course-content*')"
                            class="font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 px-3 py-2 rounded-md transition-all duration-200 ease-in-out transform hover:-translate-y-0.5">
                            {{ __('Courses') }}
                        </x-nav-link>
                    @endrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center space-x-1 text-sm font-medium text-gray-700 focus:outline-none transition duration-200 ease-in-out hover:text-gray-900">
                            <!-- Efek hover pada dropdown trigger -->
                            <div class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 mt-1 text-gray-500 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="py-2 px-4 text-sm text-gray-700">
                            <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')"
                            class="flex items-center space-x-2 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                            <!-- Efek hover pada dropdown link -->
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center space-x-2 text-red-600 hover:bg-red-100 hover:text-red-700 transition-colors">
                                <!-- Efek hover pada dropdown link logout -->
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-cloak :class="{ 'block': open, 'hidden': !open }"
        class="sm:hidden bg-white/95 backdrop-blur-sm shadow-xl transition-all duration-300">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="pl-6 hover:bg-gray-50 hover:text-gray-900">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @role('admin')
                <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories*')"
                    class="pl-6 hover:bg-gray-50 hover:text-gray-900">
                    {{ __('Categories') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.teachers.index')" :active="request()->routeIs('admin.teachers*')"
                    class="pl-6 hover:bg-gray-50 hover:text-gray-900">
                    {{ __('Teachers') }}
                </x-responsive-nav-link>
            @endrole

            @role('admin|teacher')
                <x-responsive-nav-link :href="route('admin.courses.index')" :active="request()->routeIs('admin.courses*') || request()->routeIs('admin.course-content*')"
                    class="pl-6 hover:bg-gray-50 hover:text-gray-900">
                    {{ __('Courses') }}
                </x-responsive-nav-link>
            @endrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-2 border-t border-gray-200">
            <div class="px-6 py-3">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-1 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="pl-6 hover:bg-gray-50 hover:text-gray-900">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="pl-6 text-red-600 hover:bg-red-50 hover:text-red-700">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
