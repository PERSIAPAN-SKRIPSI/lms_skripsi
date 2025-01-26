<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <!-- Dashboard -->
    <x-sidebar.link title="Dashboard" href="{{ route('dashboard') }}" :isActive="request()->routeIs('dashboard')">
        <x-slot name="icon">
            <x-heroicon-o-home class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <!-- Dropdown untuk Admin (Owner) -->
    @role('admin')
        <x-sidebar.dropdown title="Admin Management" :active="request()->routeIs('admin.categories.*') || request()->routeIs('admin.teachers.*')">
            <x-slot name="icon">
                <x-heroicon-o-cog-6-tooth class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <!-- Submenu untuk Admin -->
            <x-sidebar.link title="Categories" href="{{ route('admin.categories.index') }}" :isActive="request()->routeIs('admin.categories.index')" />
            <x-sidebar.link title="Teachers" href="{{ route('admin.teachers.index') }}" :isActive="request()->routeIs('admin.teachers.index')" />
        </x-sidebar.dropdown>
    @endrole

    <!-- Dropdown untuk Courses (admin dan Teacher) -->
    @role('admin|teacher')
        <x-sidebar.dropdown title="Course Management" :active="request()->routeIs('admin.courses.*') || request()->routeIs('admin.course_videos.*')">
            <x-slot name="icon">
                <x-heroicon-o-book-open class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <!-- Submenu untuk Courses (admin) -->
            @role('admin')
                <x-sidebar.link title="All Courses" href="{{ route('admin.courses.index') }}" :isActive="request()->routeIs('admin.courses.index')" />
            @endrole

            <!-- Submenu untuk Courses (Teacher) -->
            @role('teacher')
                <x-sidebar.link title="My Courses" href="{{ route('admin.courses.index') }}" :isActive="request()->routeIs('admin.courses.index')" />
                <x-sidebar.link title="Create Course" href="{{ route('admin.courses.create') }}" :isActive="request()->routeIs('admin.courses.create')" />
            @endrole
            <!-- Submenu untuk Courses (admin & teacher) -->
            @role('admin|teacher')
                <x-sidebar.link title="Course Videos" href="{{ route('admin.course_videos.index') }}" :isActive="request()->routeIs('admin.course_videos.*')" />
            @endrole
        </x-sidebar.dropdown>
    @endrole

    <!-- Dropdown untuk Employee -->
    @role('employee')
        <x-sidebar.dropdown title="My Learning" :active="request()->routeIs('learning.*')">
            <x-slot name="icon">
                <x-heroicon-o-academic-cap class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>

            <!-- Submenu untuk Employee -->
            <x-sidebar.link title="Enrolled Courses" href="{{ route('learning.courses') }}" :isActive="request()->routeIs('learning.courses')" />
            <x-sidebar.link title="Progress" href="{{ route('learning.progress') }}" :isActive="request()->routeIs('learning.progress')" />
        </x-sidebar.dropdown>
    @endrole

</x-perfect-scrollbar>
