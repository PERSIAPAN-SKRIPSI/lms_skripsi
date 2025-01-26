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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form method="POST"
                      action="{{ route('admin.teachers.update', $teacher) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <x-input-label for="certificate" :value="__('New Certificate (Optional)')" />
                        <input type="file" name="certificate" id="certificate"
                               class="block mt-1 w-full">
                        <x-input-error :messages="$errors->get('certificate')" class="mt-2" />
                        <p class="mt-2 text-sm text-gray-500">
                            Current: <a href="{{ Storage::url($teacher->certificate) }}"
                                      target="_blank"
                                      class="text-indigo-600 hover:text-indigo-900">
                                      View Certificate
                                   </a>
                        </p>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="cv" :value="__('New CV (Optional)')" />
                        <input type="file" name="cv" id="cv"
                               class="block mt-1 w-full">
                        <x-input-error :messages="$errors->get('cv')" class="mt-2" />
                        <p class="mt-2 text-sm text-gray-500">
                            Current: <a href="{{ Storage::url($teacher->cv) }}"
                                      target="_blank"
                                      class="text-indigo-600 hover:text-indigo-900">
                                      View CV
                                   </a>
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                            Update Teacher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
