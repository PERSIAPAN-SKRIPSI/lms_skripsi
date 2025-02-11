<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Courses Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10 flex flex-col gap-y-5">
                <div class="item-card flex flex-row gap-y-10 justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->name }}" class="rounded-2xl object-cover w-[200px] h-[150px]">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">{{ $course->name }}</h3>
                            <p class="text-slate-500 text-sm">{{ $course->category->name }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-slate-500 text-sm">Students</p>
                        <h3 class="text-indigo-950 text-xl font-bold">{{ $course->employees->count() }}</h3>
                    </div>
                     <div class="flex flex-row items-center gap-x-3">
                        @role('admin|teacher')
                             <a href="{{ route('admin.courses.edit', $course) }}" class="font-bold py-4 px-6 bg-indigo-700 text-white rounded-full">
                                 Edit Course
                            </a>
                         @endrole
                         @role('admin')
                            <form action="{{ route('admin.courses.destroy', $course) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-bold py-4 px-6 bg-red-700 text-white rounded-full">
                                    Delete
                                </button>
                            </form>
                         @endrole
                      </div>
                </div>

                <hr class="my-5">
                <div class="space-y-6">  <!-- Use space-y for vertical spacing -->
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="flex flex-col">
                            <h3 class="text-indigo-950 text-xl font-bold">Course Content</h3>
                            <p class="text-slate-500 text-sm">Manage Your Chapters & Videos</p>  <!-- Corrected typo -->
                        </div>

                        @role('admin|teacher')
                        <button onclick="document.getElementById('create-chapter-modal').showModal()" class="mt-4 md:mt-0 font-bold py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full transition duration-200">  <!-- Added mt for spacing on small screens, hover effect, and transition -->
                            Add New Chapter
                        </button>
                        @endrole
                    </div>

                    @forelse ($course->chapters as $chapter)
                    <div class="bg-white rounded-lg shadow-md p-6"> <!-- Added shadow and padding to the card -->
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-y-2 sm:gap-y-0">
                             <!-- Responsive layout for chapter info and actions -->
                            <div class="flex flex-row items-center gap-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-indigo-600"> <!-- Added color to the icon -->
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 20.25 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.077 1.947l-4.894 2.894a1.5 1.5 0 0 1-1.232 0l-4.894-2.894A2.25 2.25 0 0 1 2.25 6.993V6.75" />
                                </svg>
                                <h3 class="text-indigo-900 text-lg font-bold">{{ $chapter->name }}</h3> <!-- Slightly less dark text -->
                            </div>
                            <div class="flex flex-row items-center gap-x-3">
                                @role('admin|teacher')
                                <button onclick="document.getElementById('edit-chapter-modal-{{$chapter->id}}').showModal()" class="font-bold py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full transition duration-200"> <!-- Consistent button style -->
                                    Edit
                                </button>
                                <form method="POST" action="{{ route('admin.courses.destroy-chapter', $chapter) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-bold py-2 px-4 bg-red-600 hover:bg-red-700 text-white rounded-full transition duration-200" onclick="return confirm('Are you sure you want to delete this chapter?')"> <!-- Consistent button style -->
                                        Delete
                                    </button>
                                </form>
                                @endrole
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($chapter->videos as $video)
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="relative w-full aspect-video">
                                   <iframe width="100%" height="100%" class="absolute inset-0" src="https://www.youtube-nocookie.com/embed/{{ $video->path_video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $video->name }}</h3>
                                    <p class="text-sm text-gray-500 mb-1">{{ $video->course->name }}</p>
                                    <p class="text-xs text-gray-600">Durasi: {{ $video->duration ?? 'N/A' }}</p>  {{-- Asumsikan ada properti 'duration' --}}
                                    <p class="text-sm text-gray-700 mt-2 line-clamp-2">{{ $video->description ?? '' }}</p>  {{-- Deskripsi singkat --}}

                                    @role('admin|teacher')
                                    <div class="mt-4 flex space-x-2">
                                        <a href="{{ route('admin.courses.videos.edit', ['course' => $course, 'video' => $video]) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md text-sm transition duration-200 flex-grow text-center">Edit</a>
                                        <form method="POST" action="{{ route('admin.courses.videos.destroy', ['course' => $course, 'video' => $video]) }}" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm transition duration-200" onclick="return confirm('Are you sure you want to delete this video?')">
                                              <svg class="w-4 h-4 inline-block" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                    @endrole
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 col-span-full text-center">No videos in this chapter yet.</p>
                            @endforelse
                        </div>

                        <div class="flex justify-end mt-4">
                            <a href="{{ route('admin.courses.create.video', $course->id ) }}" class="font-bold py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white rounded-full transition duration-200"> <!-- Consistent button style -->
                                Add Video
                            </a>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500">No Chapters yet.</p>
                    @endforelse

                    <!-- Modal Create chapter -->
                    <dialog id="create-chapter-modal" class="modal">
                        <div class="modal-box bg-white rounded-lg shadow-lg p-8">  <!-- Added styling to the modal-box -->
                             <form method="dialog" class="absolute top-2 right-2">
                               <!-- Close Button -->
                                <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                            </form>
                            <form method="POST" action="{{ route('admin.courses.store-chapter', $course) }}" class="space-y-6"> <!-- Using space-y for consistent spacing -->
                                @csrf
                                <h3 class="font-bold text-lg text-indigo-900">Create New Chapter</h3>  <!-- Consistent heading style -->

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Chapter Name</label>
                                    <input type="text" name="name" id="name" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">  <!-- Consistent input style -->
                                </div>

                                <div>
                                    <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                                    <input type="number" name="order" id="order" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">  <!-- Consistent input style -->
                                </div>

                                <div class="mt-6"> <!--  Add spacing before buttons -->
                                     <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-200 ease-in-out">  <!-- Consistent button style -->
                                        Save Chapter
                                    </button>
                                </div>
                            </form>

                        </div>
                    </dialog>
                    <!-- end modal -->

                    <!-- Modal Edit chapter -->
                    @foreach ($course->chapters as $chapter)
                    <dialog id="edit-chapter-modal-{{$chapter->id}}" class="modal">
                        <div class="modal-box bg-white rounded-lg shadow-lg p-8">  <!-- Added styling to modal-box -->
                           <form method="dialog" class="absolute top-2 right-2">
                               <!-- Close Button -->
                                <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                            </form>
                            <form method="POST" action="{{ route('admin.courses.update-chapter', $chapter) }}" class="space-y-6"> <!--  Using space-y for consistent spacing -->
                                @csrf
                                @method('PUT')  <!-- Use PUT for updates -->
                                <h3 class="font-bold text-lg text-indigo-900">Edit Chapter</h3> <!-- Consistent heading style -->

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Chapter Name</label>
                                    <input type="text" name="name" id="name" required value="{{ $chapter->name }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">  <!-- Consistent input style -->
                                </div>

                                <div>
                                    <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                                    <input type="number" name="order" id="order" value="{{ $chapter->order }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">  <!-- Consistent input style -->
                                </div>

                                 <div class="mt-6">
                                    <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition duration-200 ease-in-out">  <!-- Consistent button style -->
                                        Save Changes
                                    </button>

                                </div>

                            </form>
                        </div>
                    </dialog>
                    @endforeach
                </div>
                 {{-- Modal Create chapter --}}
                    <dialog id="create-chapter-modal" class="modal">
                        <div class="modal-box">
                            <form method="POST" action="{{ route('admin.courses.store-chapter', $course) }}" class="flex flex-col gap-y-4">
                                @csrf
                                <h3 class="font-bold text-lg mb-4">Create New Chapter</h3>
                                <div>
                                    <label for="name" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Chapter Name</label>
                                    <input type="text" name="name" id="name" required class="w-full px-4 py-2 border rounded focus:outline-none focus:border-purple-500 dark:bg-gray-700 dark:text-gray-100">
                                </div>

                                <div>
                                    <label for="order" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Order</label>
                                    <input type="number" name="order" id="order"  class="w-full px-4 py-2 border rounded focus:outline-none focus:border-purple-500 dark:bg-gray-700 dark:text-gray-100">
                                 </div>

                                <div class="modal-action">
                                  <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">Save Chapter</button>
                                 <button onclick="document.getElementById('create-chapter-modal').close()" type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Close</button>
                              </div>
                         </form>
                    </div>
                 </dialog>
                    {{-- end modal --}}
                 {{-- Modal Edit chapter --}}
                  @foreach ($course->chapters as $chapter)
                     <dialog id="edit-chapter-modal-{{$chapter->id}}" class="modal">
                        <div class="modal-box">
                           <form method="POST" action="{{ route('admin.courses.update-chapter', $chapter) }}" class="flex flex-col gap-y-4">
                              @csrf
                                <h3 class="font-bold text-lg mb-4">Edit Chapter</h3>
                                  <div class="mb-4">
                                    <label for="name" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Chapter Name</label>
                                    <input type="text" name="name" id="name" required value="{{$chapter->name}}" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-purple-500 dark:bg-gray-700 dark:text-gray-100">
                              </div>
                                <div class="mb-4">
                                   <label for="order" class="block font-medium text-gray-700 dark:text-gray-300 mb-2">Order</label>
                                   <input type="number" name="order" id="order" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-purple-500 dark:bg-gray-700 dark:text-gray-100" value="{{$chapter->order}}">
                                </div>
                             <div class="modal-action">
                                  <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">Save Changes</button>
                                <button onclick="document.getElementById('edit-chapter-modal-{{$chapter->id}}').close()"  type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Close</button>
                            </div>
                           </form>
                        </div>
                    </dialog>
                   @endforeach
                   {{-- end modal --}}
            </div>
        </div>
    </div>
</x-app-layout>
