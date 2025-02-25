<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Video') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($errors->any())
                        <div class="mb-4">
                            @foreach($errors->all() as $error)
                                <div class="py-3 px-4 rounded-lg bg-red-100 text-red-700 mb-2">
                                    {{ $error }}
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.courses.videos.update', ['course' => $course, 'video' => $courseVideo]) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Video Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $courseVideo->name) }}" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="path_video" :value="__('YouTube Video URL')" />
                            <x-text-input id="path_video" class="block mt-1 w-full" type="text" name="path_video" value="{{ old('path_video', $courseVideo->path_video) }}" autocomplete="url" />
                            <x-input-error :messages="$errors->get('path_video')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-1">Paste the YouTube video URL here.</p>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="chapter_id" :value="__('Chapter')" />
                            <select name="chapter_id" id="chapter_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Chapter</option>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}" {{ (old('chapter_id', $courseVideo->chapter_id) == $chapter->id) ? 'selected' : '' }}>{{ $chapter->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('chapter_id')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="duration_preview" :value="__('Video Duration (Auto-filled)')" />
                            <x-text-input id="duration_preview" class="block mt-1 w-full bg-gray-100" type="text" readonly value="{{ $courseVideo->duration ? formatDurationInView($courseVideo->duration) : '' }}" />
                            <input type="hidden" name="duration" id="duration" value="{{ $courseVideo->duration }}">
                        </div>

                        <div class="mt-6">
                            <div id="video_preview">
                                @if($courseVideo->path_video)
                                    @php
                                        $videoId = extractYouTubeId($courseVideo->path_video);
                                    @endphp
                                    @if($videoId)
                                        <div class="aspect-w-16 aspect-h-9">
                                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Update Video') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('path_video').addEventListener('input', function() {
            const url = this.value;
            const videoId = extractVideoId(url);

            if (videoId) {
                // Clear any existing error messages
                document.querySelectorAll('.text-red-500').forEach(el => el.remove());
                updateVideoPreview(videoId);
                getVideoDuration(videoId);
            } else {
                // Clear video preview and duration
                document.getElementById('video_preview').innerHTML = '';
                document.getElementById('duration_preview').value = '';
                document.getElementById('duration').value = '';

                // Show error message if URL is invalid
                if (url.length > 0) {
                    const errorElement = document.createElement('p');
                    errorElement.className = 'text-red-500 text-sm mt-1';
                    errorElement.textContent = 'Invalid YouTube URL';
                    this.parentNode.appendChild(errorElement);
                }
            }
        });


        function extractVideoId(url) {
            const patterns = [
                /(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=))([a-zA-Z0-9_-]{11})/,
                /(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/,
                /(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/
            ];

            for (let pattern of patterns) {
                const match = url.match(pattern);
                if (match) return match[1];
            }
            return null;
        }


        function updateVideoPreview(videoId) {
            document.getElementById('video_preview').innerHTML = `
                <div class="aspect-w-16 aspect-h-9">
                    <iframe src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>
                </div>
            `;
        }

        async function getVideoDuration(videoId) {
            const apiKey = '{{ config('services.youtube.api_key') }}'; // Access API Key from config
            const apiUrl = `https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id=${videoId}&key=${apiKey}`;

            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                if (data.items && data.items.length > 0) {
                    const duration = data.items[0].contentDetails.duration;
                    const formattedDuration = formatDuration(duration);
                    const durationInSeconds = convertDurationToSeconds(duration);

                    document.getElementById('duration_preview').value = formattedDuration;
                    document.getElementById('duration').value = durationInSeconds;

                } else {
                    document.getElementById('duration_preview').value = 'Duration Not Found';
                    document.getElementById('duration').value = 0;
                }
            } catch (error) {
                console.error('Error fetching video duration:', error);
                document.getElementById('duration_preview').value = 'Error Fetching Duration';
                document.getElementById('duration').value = 0;
            }
        }

        function formatDuration(duration) {
            const match = duration.match(/PT(\d+H)?(\d+M)?(\d+S)?/);
            const hours = (match[1] ? parseInt(match[1]) : 0);
            const minutes = (match[2] ? parseInt(match[2]) : 0);
            const seconds = (match[3] ? parseInt(match[3]) : 0);

            let formatted = '';
            if (hours > 0) formatted += `${hours}:`;
            formatted += `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            return formatted;
        }

        function convertDurationToSeconds(duration) {
            const match = duration.match(/PT(\d+H)?(\d+M)?(\d+S)?/);
            const hours = (match[1] ? parseInt(match[1]) : 0);
            const minutes = (match[2] ? parseInt(match[2]) : 0);
            const seconds = (match[3] ? parseInt(match[3]) : 0);

            return hours * 3600 + minutes * 60 + seconds;
        }
    </script>
    @endpush
</x-app-layout>

@php
function extractYouTubeId($url) {
    $patterns = [
        '/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=))([a-zA-Z0-9_-]{11})/',
        '/(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/',
        '/(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function formatDurationInView($seconds) {
    if ($seconds < 60) {
        return sprintf("0:%02d", $seconds);
    }

    $minutes = floor($seconds / 60);
    $remainingSeconds = $seconds % 60;

    if ($minutes < 60) {
        return sprintf("%d:%02d", $minutes, $remainingSeconds);
    }

    $hours = floor($minutes / 60);
    $remainingMinutes = $minutes % 60;

    return sprintf("%d:%02d:%02d", $hours, $remainingMinutes, $remainingSeconds);
}
@endphp
