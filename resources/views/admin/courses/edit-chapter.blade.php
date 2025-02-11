<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Chapter') }}
            </h2>
              <a href="{{ route('admin.courses.show', $chapter->course) }}" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
           </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                  <form method="POST" action="{{ route('admin.courses.update-chapter', $chapter) }}" class="flex flex-col gap-y-4">
                       @csrf
                       <div>
                           <x-input-label for="name" :value="__('Chapter Name')" />
                          <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $chapter->name }}" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                       <div>
                           <x-input-label for="order" :value="__('Order')" />
                            <x-text-input id="order" class="block mt-1 w-full" type="number" name="order" value="{{ $chapter->order }}"   autocomplete="order" />
                            <x-input-error :messages="$errors->get('order')" class="mt-2" />
                       </div>
                      <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-700 hover:bg-indigo-900 text-white font-bold py-3 px-4 rounded-lg">
                            Update Chapter
                         </button>
                    </div>
                 </form>
            </div>
       </div>
    </div>
</div>
</x-app-layout>
