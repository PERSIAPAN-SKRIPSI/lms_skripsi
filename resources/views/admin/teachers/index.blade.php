<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl font-semibold leading-tight">
                {{ __('Manage Teachers') }}
            </h2>
            <a href="{{ route('admin.teachers.create') }}"
                class="group relative inline-block px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-indigo-600 hover:to-purple-500 text-white rounded-full shadow-md transition-all duration-300 ease-in-out">
                <span class="absolute inset-0 bg-white opacity-10 rounded-full blur-lg group-hover:opacity-20 transition-opacity"></span>
                <span class="font-bold text-base relative z-10">
                    Add New
                </span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl p-8">
                <div class="flex flex-col gap-y-8">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif
                    @if(session('warning'))
                        <div class="bg-orange-100 border border-orange-400 text-orange-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Warning!</strong>
                            <span class="block sm:inline">{{ session('warning') }}</span>
                        </div>
                    @endif
                    @forelse ($teachers as $teacher)
                        <div class="item-card relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6 p-8 border border-gray-200 rounded-2xl bg-white shadow-sm hover:shadow-lg transition-all duration-300">
                            <div class="flex flex-row items-center gap-x-6 w-full md:w-auto">
                                 <img src="{{ Storage::url($teacher->user->avatar) }}"
                                alt="" class="rounded-2xl object-cover w-[90px] h-[90px]">
                                <div class="flex flex-col">
                                    <h3 class="text-indigo-900 text-2xl font-bold">{{ $teacher->user->name }}</h3>
                                    <p class="text-gray-600 text-base">{{ $teacher->user->email }}</p>
                                    <div class="mt-2">
                                        <span class="px-3 py-1.5 text-xs font-semibold rounded-full
                                            {{ $teacher->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                            {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                             <div class="flex flex-col md:items-end gap-3 w-full md:w-auto">
                                <div class="flex flex-row items-center gap-x-4">
                                    <a href="{{ route('admin.teachers.show', $teacher) }}"
                                        class="flex items-center justify-center px-5 py-2 text-sm font-medium text-indigo-600 bg-indigo-100 rounded-full hover:bg-indigo-200 transition-colors">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                        class="flex items-center justify-center px-5 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-full hover:bg-gray-200 transition-colors">
                                         <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.teachers.activate', $teacher) }}" method="POST"
                                    class="inline-block">
                                   @csrf
                                  @method('PUT')
                                  <button type="submit"
                                    class="flex items-center justify-center px-5 py-2 text-sm font-medium rounded-full transition-colors
                                    {{ $teacher->is_active ? 'text-red-600 bg-red-100 hover:bg-red-200' : 'text-green-600 bg-green-100 hover:bg-green-200' }}">
                                    @if ($teacher->is_active)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                        Deactivate
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Activate
                                    @endif

                                    </button>
                               </form>


                                    <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-center px-5 py-2 text-sm font-medium text-red-600 bg-red-100 rounded-full hover:bg-red-200 transition-colors">
                                             <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                <!-- Date with a slightly better presentation -->
                                <p class="text-gray-500 text-sm">
                                     Registered:  <time datetime="{{ $teacher->created_at->toIso8601String() }}">{{ $teacher->created_at->format('F j, Y') }}</time>
                                </p>
                            </div>
                              <!-- Subtle background pattern (optional) -->
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-transparent opacity-50 rounded-2xl -z-10"></div>
                        </div>
                    @empty
                         <!-- Empty state card -->
                        <div class="p-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>

                            <p class="mt-4 text-gray-500 text-lg">No teachers found. Start by adding a new teacher.</p>
                        </div>
                    @endforelse
                    <!-- Modern Pagination -->
                    {{ $teachers->links() }}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
