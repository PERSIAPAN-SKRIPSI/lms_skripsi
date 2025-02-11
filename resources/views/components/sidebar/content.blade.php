{{-- resources/views/components/sidebar.blade.php --}}
<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3 py-6 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"> {{-- Dark background and border --}}

    @php
    $currentRouteName = Route::currentRouteName();
    @endphp

    <div class="space-y-6">
        @if (auth()->user()->hasRole('admin'))
            <div>
                <h3 class="font-semibold text-gray-900 mb-3 px-3 leading-tight dark:text-white">ADMINISTRATION</h3> {{-- Dark mode text color for title --}}
                <x-sidebar.link title="Dashboard" href="{{ route('admin.dashboard') }}" :isActive="$currentRouteName == 'admin.dashboard'">
                    <x-slot name="icon">
                        <x-icons.dashboard class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400" aria-hidden="true" /> {{-- Dark mode icon color --}}
                    </x-slot>
                </x-sidebar.link>

                <x-sidebar.dropdown title="Course Management" :isActive="Str::startsWith($currentRouteName, 'admin.courses.') || Str::startsWith($currentRouteName, 'admin.categories.')">
                    <x-slot name="icon">
                        <x-heroicon-o-collection class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400" aria-hidden="true" /> {{-- Dark mode icon color --}}
                    </x-slot>
                    <x-sidebar.sublink title="Courses" href="{{ route('admin.courses.index') }}" :isActive="Str::startsWith($currentRouteName, 'admin.courses.')" />
                    <x-sidebar.sublink title="Categories" href="{{ route('admin.categories.index') }}" :isActive="Str::startsWith($currentRouteName, 'admin.categories.')" />
                </x-sidebar.dropdown>

                <x-sidebar.dropdown title="Teacher Management" :isActive="Str::startsWith($currentRouteName, 'admin.teachers.')">
                    <x-slot name="icon">
                        <x-heroicon-o-user-group class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400" aria-hidden="true" /> {{-- Dark mode icon color --}}
                    </x-slot>
                    <x-sidebar.sublink title="Teachers" href="{{ route('admin.teachers.index') }}" :isActive="Str::startsWith($currentRouteName, 'admin.teachers.')" />
                </x-sidebar.dropdown>
            </div>
            <hr class="border-gray-200 dark:border-gray-700"> {{-- Dark mode border color for hr --}}
        @endif

        @if(auth()->user()->hasRole('teacher') && auth()->user()->teacher && auth()->user()->teacher->is_active)
            <div>
                <h3 class="font-semibold text-gray-900 mb-3 px-3 leading-tight dark:text-white">TEACHER</h3> {{-- Dark mode text color for title --}}
                <x-sidebar.link title="Dashboard" href="{{ route('teacher.dashboard') }}" :isActive="$currentRouteName == 'teacher.dashboard'">
                    <x-slot name="icon">
                        <x-icons.dashboard class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400" aria-hidden="true" /> {{-- Dark mode icon color --}}
                    </x-slot>
                </x-sidebar.link>

                <x-sidebar.dropdown title="Course Management" :isActive="Str::startsWith($currentRouteName, 'teacher.courses.')">
                    <x-slot name="icon">
                        <x-heroicon-o-collection class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400" aria-hidden="true" /> {{-- Dark mode icon color --}}
                    </x-slot>
                    <x-sidebar.sublink title="My Courses" href="{{ route('admin.courses.index') }}" :isActive="Str::startsWith($currentRouteName, 'teacher.courses.')" />
                    <x-sidebar.sublink title="Categories" href="{{ route('admin.categories.index') }}" :isActive="Str::startsWith($currentRouteName, 'teacher.categories.')" />
                </x-sidebar.dropdown>
            </div>
            <hr class="border-gray-200 dark:border-gray-700"> {{-- Dark mode border color for hr --}}
        @endif

        @if(auth()->user()->hasRole('employee'))
            <div>
                <h3 class="font-semibold text-gray-900 mb-3 px-3 leading-tight dark:text-white">EMPLOYEE</h3> {{-- Dark mode text color for title --}}
                <x-sidebar.link title="Dashboard" href="{{ route('employee.dashboard') }}" :isActive="$currentRouteName == 'employee.dashboard'">
                    <x-slot name="icon">
                        <x-icons.dashboard class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400" aria-hidden="true" /> {{-- Dark mode icon color --}}
                    </x-slot>
                </x-sidebar.link>
                <x-sidebar.link title="Courses" href="{{ route('employee.courses.index') }}" :isActive="Str::startsWith($currentRouteName, 'employee.courses.')">
                    <x-slot name="icon">
                        <x-heroicon-o-collection class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400" aria-hidden="true" /> {{-- Dark mode icon color --}}
                    </x-slot>
                </x-sidebar.link>
            </div>
            <hr class="border-gray-200 dark:border-gray-700"> {{-- Dark mode border color for hr --}}
        @endif

        @if(!auth()->user()->hasRole(['admin', 'teacher', 'employee']))
            <div>
                <h3 class="font-semibold text-gray-900 mb-3 px-3 leading-tight dark:text-white">GENERAL</h3> {{-- Dark mode text color for title --}}
                <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
                    <x-slot name="icon">
                        <x-icons.dashboard class="flex-shrink-0 w-5 h-5 text-gray-600 dark:text-gray-400" aria-hidden="true" /> {{-- Dark mode icon color --}}
                    </x-slot>
                </x-sidebar.link>
            </div>
        @endif
    </div>

</x-perfect-scrollbar>
