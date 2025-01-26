<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Teachers') }}
            </h2>
            <a href="{{ route('admin.teachers.create') }}"
                class="font-bold py-3 px-6 bg-indigo-700 hover:bg-indigo-800 text-white rounded-md transition-all">
                Add New
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col gap-y-5">
                @forelse ($teachers as $teacher)
                    <div class="item-card flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-6 border rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="flex flex-row items-center gap-x-4 w-full md:w-auto">
                            <img src="{{ $teacher->user->avatar_url }}" alt="Avatar"
                                class="rounded-xl object-cover w-20 h-20">
                            <div class="flex flex-col">
                                <h3 class="text-indigo-950 text-lg font-bold">{{ $teacher->user->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ $teacher->user->email }}</p>
                                <div class="mt-1">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $teacher->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                         <div class="flex flex-col md:items-end gap-2 w-full md:w-auto">
                            <div class="flex flex-row items-center gap-x-3">
                                <a href="{{ route('admin.teachers.show', $teacher) }}"
                                    class="px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 rounded-md hover:bg-indigo-100">
                                    View
                                </a>
                                <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50 rounded-md hover:bg-gray-100">
                                    Edit
                                </a>

                                <form action="{{ route('admin.teachers.activate', $teacher) }}" method="POST"
                                      class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="px-4 py-2 text-sm font-medium {{ $teacher->is_active ? 'text-red-700 bg-red-50 hover:bg-red-100' : 'text-green-700 bg-green-50 hover:bg-green-100' }} rounded-md">
                                        {{ $teacher->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>


                                <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 text-sm font-medium text-red-700 bg-red-50 rounded-md hover:bg-red-100">
                                        Delete
                                    </button>
                                </form>
                            </div>
                            <p class="text-gray-500 text-sm">
                                Registered: {{ $teacher->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        No teachers found. Start by adding a new teacher.
                    </div>
                @endforelse
                     {{ $teachers->links() }}

            </div>
        </div>
    </div>
</x-app-layout>
