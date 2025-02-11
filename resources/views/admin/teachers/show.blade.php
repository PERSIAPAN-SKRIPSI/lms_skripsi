<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Teacher Details') }}
            </h2>
            <a href="{{ route('admin.teachers.index') }}"
                class="font-bold py-3 px-6 bg-gray-500 hover:bg-gray-600 text-white rounded-md transition-all">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-indigo-950">Teacher Information</h3>
                </div>
                <div class="mb-4">
                    <img src="{{ Storage::url($teacher->user->avatar) }}" alt="Avatar"
                        class="rounded-full object-cover w-20 h-20 mb-4">
                    <strong>Name:</strong> {{ $teacher->user->name }}
                    <br>
                    <strong>Email:</strong> {{ $teacher->user->email }}
                    <br>
                     <strong>Occupation:</strong> {{ $teacher->user->occupation }}
                </div>

               <div class="mb-4">
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $teacher->is_active ? 'green' : 'red' }}-100 text-{{ $teacher->is_active ? 'green' : 'red' }}-800 rounded-full px-2 py-1 text-xs">
                            {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="mb-4">
                   <strong>Specialization:</strong> {{ $teacher->specialization ?? '-' }}
                </div>

                <div class="mb-4">
                    <strong>Certificate:</strong>
                    @if($certificateUrl)
                        <a href="{{ $certificateUrl }}" target="_blank"
                            class="text-indigo-500 hover:text-indigo-700 underline">View Certificate</a>
                    @else
                        <p>No certificate uploaded</p>
                    @endif
                </div>

                <div class="mb-4">
                    <strong>CV:</strong>
                    @if($cvUrl)
                        <a href="{{ $cvUrl }}" target="_blank"
                            class="text-indigo-500 hover:text-indigo-700 underline">View CV</a>
                    @else
                        <p>No CV uploaded</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
