<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Teacher') }}
            </h2>
            <a href="{{ route('admin.teachers.index') }}"
               class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl p-8"> {{-- Shadow increased and rounded corners --}}
                <form method="POST"
                      action="{{ route('admin.teachers.update', $teacher) }}"
                      enctype="multipart/form-data"
                      class="space-y-6"> {{-- Added spacing --}}
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="certificate" :value="__('New Certificate (Optional)')" class="block mb-2 font-medium text-gray-700"/> {{-- Label styling --}}
                        <input type="file" name="certificate" id="certificate"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"> {{-- Input styling --}}
                        <x-input-error :messages="$errors->get('certificate')" class="mt-2 text-sm text-red-600" /> {{-- Error styling --}}
                        @if($teacher->certificate)
                            <p class="mt-2 text-sm text-gray-500">
                                Current Certificate:
                                <a href="{{ Storage::url($teacher->certificate) }}"
                                   target="_blank"
                                   class="text-indigo-600 hover:text-indigo-900 font-medium"> {{-- Link styling --}}
                                    View Certificate
                                </a>
                            </p>
                        @else
                            <p class="mt-2 text-sm text-gray-500">No current certificate uploaded.</p>
                        @endif
                    </div>

                    <div>
                        <x-input-label for="cv" :value="__('New CV (Optional)')" class="block mb-2 font-medium text-gray-700"/> {{-- Label styling --}}
                        <input type="file" name="cv" id="cv"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"> {{-- Input styling --}}
                        <x-input-error :messages="$errors->get('cv')" class="mt-2 text-sm text-red-600" /> {{-- Error styling --}}
                        @if($teacher->cv)
                            <p class="mt-2 text-sm text-gray-500">
                                Current CV:
                                <a href="{{ Storage::url($teacher->cv) }}"
                                   target="_blank"
                                   class="text-indigo-600 hover:text-indigo-900 font-medium"> {{-- Link styling --}}
                                    View CV
                                </a>
                            </p>
                        @else
                            <p class="mt-2 text-sm text-gray-500">No current CV uploaded.</p>
                        @endif
                    </div>

                    <div class="flex justify-between items-center">
                        <div>
                            <label for="is_active" class="inline-flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" {{ $teacher->is_active ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700 text-sm font-medium">{{ __('Active') }}</span>
                            </label>
                        </div>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 border border-transparent rounded-md font-semibold text-base text-white tracking-wider transition ease-in-out duration-150"> {{-- Button styling --}}
                            Update Teacher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
