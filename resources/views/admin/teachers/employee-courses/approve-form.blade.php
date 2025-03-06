<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Approve Employee Course Enrollment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">Approve Enrollment for {{ $enrollCourse->employee->name }} in {{ $enrollCourse->course->name }}</h3>

                    <form action="{{ route('admin.teacher.employee-courses.approve', $enrollCourse) }}" method="POST">
                        @csrf
                        <button type="submit" class="common_btn">Approve</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
