<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport"
      content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
   <meta name="base_url" content="{{ url('/') }}">
   <meta name="csrf_token" content="{{ csrf_token() }}">
   <title>EduCore - Online Courses & Education HTML Template</title>
   <link type="image/png" href="images/favicon.png" rel="icon">
   <link href="{{ asset('frontend/assets/css/all.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/animated_barfiller.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/slick.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/venobox.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/scroll_button.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/nice-select.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/pointer.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/jquery.calendar.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/range_slider.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/startRating.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/video_player.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/jquery.simple-bar-graph.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/select2.min.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/sticky_menu.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/animate.css') }}" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" rel="stylesheet">

   <link href="{{ asset('frontend/assets/css/spacing.css') }}" rel=" stylesheet">
   <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
   <link href="{{ asset('frontend/assets/css/responsive.css') }}" rel="stylesheet">
   {{-- @vite(['resources/js/frontend/player.js']) --}}

   <!-- Custom CSS for Quiz Section -->
  {{-- <!-- Custom CSS for Quiz Section -->
  <style>
    .quiz-section {
      background-color: #fff; /* White background for quiz section */
      border-radius: 8px;
      padding: 15px;
      margin-top: 15px;
      border-left: 3px solid #007bff; /* Slightly thinner border */
      box-shadow: 0 1px 3px rgba(0,0,0,.1); /* Subtle shadow */
    }

    .quiz-section h5 {
      color: #333;
      font-size: 15px; /* Slightly smaller font size */
      font-weight: 500; /* Lighter font weight */
      margin-bottom: 8px; /* Reduced margin */
      display: flex;
      align-items: center;
    }

    .quiz-section h5:before {
      content: '\f059';
      font-family: 'Font Awesome 5 Free';
      font-weight: 900;
      margin-right: 6px; /* Reduced margin */
      color: #007bff;
      font-size: 0.9em; /* Slightly smaller icon */
    }

    .quiz-link {
      padding: 6px 0; /* Reduced padding */
      display: block;
      transition: all 0.3s ease;
    }

    .quiz-link a {
      display: flex;
      align-items: center;
      color: #555; /* Darker gray color */
      font-weight: 400; /* Even lighter font weight */
      text-decoration: none;
      padding: 6px 10px; /* Reduced padding */
      border-radius: 5px;
      transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease; /* Smoother transitions */
    }

    .quiz-link a:hover {
      background-color: #f8f9fa; /* Lighter hover background */
      color: #007bff;
      transform: translateX(3px); /* Reduced hover transform */
    }

    .quiz-link a:before {
      content: '\f15c';
      font-family: 'Font Awesome 5 Free';
      font-weight: 400;
      margin-right: 8px; /* Reduced margin */
      color: #777; /* Lighter icon color */
      font-size: 0.85em; /* Slightly smaller icon */
    }

    .quiz-info {
      display: flex;
      align-items: center;
      margin-left: auto;
      font-size: 11px; /* Even smaller font size */
      color: #777; /* Lighter color */
    }

    /* Improved accordion styling */
    .accordion-item {
      border: none; /* Remove border */
      margin-bottom: 8px; /* Reduced margin */
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 1px 3px rgba(0,0,0,.1); /* Subtle shadow for accordion items */
    }

    .accordion-button {
      padding: 12px 15px; /* Reduced padding */
      font-weight: 500; /* Lighter font weight */
      background-color: #fff; /* White background */
      border-radius: 8px !important; /* Ensure rounded corners */
      color: #444; /* Darker text color */
    }

    .accordion-button:not(.collapsed) {
      background-color: #f0f4f8; /* Lighter background when expanded */
      color: #007bff;
      box-shadow: none; /* Remove shadow when expanded */
    }

    .accordion-button:focus {
      box-shadow: none; /* Remove focus outline */
      border-color: transparent;
    }


    .accordion-button span {
      background-color: #e9ecef;
      padding: 2px 6px; /* Reduced padding */
      border-radius: 4px;
      font-size: 11px; /* Smaller font size */
      margin-left: 8px; /* Reduced margin */
      color: #6c757d;
    }

    .form-check {
      margin-bottom: 6px; /* Reduced margin */
    }

    .video-link {
      cursor: pointer;
      padding: 8px 10px; /* Consistent padding */
      border-radius: 5px;
      transition: background-color 0.3s ease, color 0.3s ease; /* Smoother transitions */
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: #555; /* Darker text color */
      font-weight: 400; /* Lighter font weight */
      text-decoration: none; /* Ensure no underlines on hover if used as links */
    }

    .video-link:hover {
      background-color: #f8f9fa; /* Lighter hover background */
      color: #007bff;
    }

    .form-check-input:checked + .video-link {
      color: #007bff;
      font-weight: 500;
    }

    .form-check-input {
      margin-top: 0.2em; /* Adjust checkbox vertical alignment */
    }

    /* Completed quiz styling */
    .quiz-completed {
      background-color: #f0f9f4; /* Very light green background */
      border-left: 3px solid #28a745; /* Thinner border */
    }

    /* Status indicators */
    .status-indicator {
      display: inline-block;
      width: 10px; /* Smaller indicator */
      height: 10px; /* Smaller indicator */
      border-radius: 50%;
      margin-right: 4px; /* Reduced margin */
    }

    .status-completed {
      background-color: #28a745;
    }

    .status-pending {
      background-color: #ffc107;
    }

    /* Video lock/unlock styling */
    .video-link-locked {
      opacity: 0.6; /* Slightly more transparent */
      pointer-events: auto; /* Keep pointer events for locked videos if needed */
      color: #999; /* Lighter color for locked videos */
    }
     .video-link-locked:hover {
        background-color: transparent; /* No background hover effect on locked videos */
        color: #999; /* Keep lighter color on hover */
     }
  </style> --}}
</head>

<body class="home_3">


 <!--============ PRELOADER START ===========-->
   <div id="preloader">
      <div class="preloader_icon">
         <img class="img-fluid" src="{{ asset('frontend/assets/images/preloader.png') }}" alt="Preloader">
      </div>
   </div>
   <!--============ PRELOADER START ===========-->

 <!--===========================
         COURSE VIDEO START
     ============================-->
     <section class="wsus__course_video">
        <div class="col-12">
            <div class="wsus__course_header">
                <a href="{{ route('employees-dashboard.courses.index') }}"><i class="fas fa-angle-left"></i>
                    {{ $course->name }}</a>
                    <p>Your Progress: {{ $overallProgress['completed_items'] }} of {{ $overallProgress['total_items'] }} ({{ $overallProgress['percentage'] }}%)</p>
            </div>
        </div>
        <div class="wsus__course_video_player">
            @if ($firstVideo)
                <video class="video-js vjs-default-skin" id="vid1" data-video-id="{{ $firstVideo->id }}"
                    data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "https://youtu.be/{{ $firstVideo->path_video }}"}] }'
                    controls autoplay width="640" height="264">
                </video>
            @else
                <p>Tidak ada video yang tersedia untuk saat ini.</p>
            @endif
        </div>
        <div class="wsus__course_sidebar d-none d-lg-block md:w-1/4">
            <h2 class="video_heading">Course Content</h2>
            <div class="accordion" id="accordionExample">
                @foreach ($chapters as $chapter)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $chapter->id }}" type="button"
                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $chapter->id }}">
                                <b>{{ $chapter->name }}</b>
                                @php
                                    $completedVideos = 0;
                                    $totalVideos = $chapter->videos->count();

                                    // Count completed videos in this chapter
                                    if(isset($courseProgress)) {
                                        foreach($chapter->videos as $video) {
                                            foreach($courseProgress as $chapterProgress) {
                                                if(isset($chapterProgress['videos'])) {
                                                    foreach($chapterProgress['videos'] as $videoProgress) {
                                                        if($videoProgress['video_id'] == $video->id && $videoProgress['is_completed']) {
                                                            $completedVideos++;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                <span>{{ $completedVideos }}/{{ $totalVideos }}</span>
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                            id="collapse{{ $chapter->id }}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                @foreach ($chapter->videos as $video)
                                    @php
                                        $isVideoCompleted = false;

                                        // Check if this video is completed
                                        if(isset($courseProgress)) {
                                            foreach($courseProgress as $chapterProgress) {
                                                if(isset($chapterProgress['videos'])) {
                                                    foreach($chapterProgress['videos'] as $videoProgress) {
                                                        if($videoProgress['video_id'] == $video->id && $videoProgress['is_completed']) {
                                                            $isVideoCompleted = true;
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        // Determine if this video should be unlocked
                                        $canAccessThisVideo = true;
                                        if ($loop->index > 0) {
                                            $previousVideo = $chapter->videos[$loop->index - 1];
                                            $isPreviousVideoCompleted = false;

                                            if(isset($courseProgress)) {
                                                foreach($courseProgress as $chapterProgress) {
                                                    if(isset($chapterProgress['videos'])) {
                                                        foreach($chapterProgress['videos'] as $videoProgress) {
                                                            if($videoProgress['video_id'] == $previousVideo->id && $videoProgress['is_completed']) {
                                                                $isPreviousVideoCompleted = true;
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            $canAccessThisVideo = $isPreviousVideoCompleted || $isVideoCompleted;
                                        }
                                    @endphp
                                    <div class="form-check video-item" data-video-id="{{ $video->id }}">
                                        <input class="form-check-input video-checkbox"
                                            id="video-{{ $video->id }}" data-video-id="{{ $video->id }}"
                                            type="checkbox" value=""
                                            {{ $isVideoCompleted ? 'checked' : '' }}
                                            >
                                        <label class="form-check-label video-link {{ $canAccessThisVideo ? '' : 'video-link-locked' }}"
                                            data-video-id="{{ $video->id }}"
                                            data-video-path="{{ $video->path_video }}"
                                            data-video-name="{{ $video->name }}"
                                            for="video-{{ $video->id }}">
                                            @if($isVideoCompleted)
                                                <span class="status-indicator status-completed" title="Completed"></span>
                                            @endif
                                            {{ $video->name }}
                                            <span>
                                                <img class="img-fluid"
                                                    src="{{ asset('frontend/assets/images/video_icon_black_2.png') }}"
                                                    alt="video">
                                                {{ gmdate('i:s', $video->duration) }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach

                                @if ($chapter->quizzes->isNotEmpty())
                                    @php
                                        $isQuizPassed = false;
                                        $quizId = null;

                                        // Check if quiz in this chapter is passed
                                        if(isset($courseProgress)) {
                                            foreach($courseProgress as $chapterProgress) {
                                                if(isset($chapterProgress['quizzes'])) {
                                                    foreach($chapterProgress['quizzes'] as $quizProgress) {
                                                        foreach($chapter->quizzes as $quiz) {
                                                            if($quizProgress['quiz_id'] == $quiz->id) {
                                                                $quizId = $quiz->id;
                                                                if($quizProgress['is_passed']) {
                                                                    $isQuizPassed = true;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        // Determine if all videos in this chapter are completed
                                        $allVideosInChapterCompleted = true;
                                        foreach($chapter->videos as $video) {
                                            $isThisVideoCompleted = false;
                                            if(isset($courseProgress)) {
                                                foreach($courseProgress as $chapterProgress) {
                                                    if(isset($chapterProgress['videos'])) {
                                                        foreach($chapterProgress['videos'] as $videoProgress) {
                                                            if($videoProgress['video_id'] == $video->id && $videoProgress['is_completed']) {
                                                                $isThisVideoCompleted = true;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            if(!$isThisVideoCompleted) {
                                                $allVideosInChapterCompleted = false;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <div class="quiz-section {{ $isQuizPassed ? 'quiz-completed' : '' }}">
                                        <h5>Kuis Chapter</h5>
                                        @foreach ($chapter->quizzes as $quiz)
                                            <div class="quiz-link">
                                                <a href="{{ route('employees-dashboard.quiz-info', $quiz->id) }}"
                                                   class="{{ $allVideosInChapterCompleted || $isQuizPassed ? '' : 'video-link-locked' }}">
                                                    @if($isQuizPassed)
                                                        <span class="status-indicator status-completed" title="Passed"></span>
                                                    @endif
                                                    {{ $quiz->title }}
                                                    <span class="quiz-info">
                                                        <i class="far fa-clock me-1"></i> {{ $quiz->time_limit ?? '15' }}
                                                        menit
                                                    </span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--===========================
         COURSE VIDEO END
     ============================-->

   <!--jquery library js-->
   <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
   <!--bootstrap js-->
   <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
   <!--font-awesome js-->
   <script src="{{ asset('frontend/assets/js/Font-Awesome.js') }}"></script>
   <!--marquee js-->
   <script src="{{ asset('frontend/assets/js/jquery.marquee.min.js') }}"></script>
   <!--slick js-->
   <script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
   <!--countup js-->
   <script src="{{ asset('frontend/assets/js/jquery.waypoints.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/jquery.countup.min.js') }}"></script>
   <!--venobox js-->
   <script src="{{ asset('frontend/assets/js/venobox.min.js') }}"></script>
   <!--nice-select js-->
   <script src="{{ asset('frontend/assets/js/jquery.nice-select.min.js') }}"></script>
   <!--Scroll Button js-->
   <script src="{{ asset('frontend/assets/js/scroll_button.js') }}"></script>
   <!--pointer js-->
   <script src="{{ asset('frontend/assets/js/pointer.js') }}"></script>
   <!--range slider js-->
   <script src="{{ asset('frontend/assets/js/range_slider.js') }}"></script>
   <!--barfiller js-->
   <script src="{{ asset('frontend/assets/js/animated_barfiller.js') }}"></script>
   <!--calendar js-->
   <script src="{{ asset('frontend/assets/js/jquery.calendar.js') }}"></script>
   <!--starRating js-->
   <script src="{{ asset('frontend/assets/js/starRating.js') }}"></script>
   <!--Bar Graph js-->
   <script src="{{ asset('frontend/assets/js/jquery.simple-bar-graph.min.js') }}"></script>
   <!--select2 js-->
   <script src="{{ asset('frontend/assets/js/select2.min.js') }}"></script>
   <!--Video player js-->
   <script src="{{ asset('frontend/assets/js/video_player.min.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/video_player_youtube.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/videojs-vimeo.umd.js') }}"></script>
   <script src="https://unpkg.com/jszip/dist/jszip.min.js"></script>
   <script src="{{ asset('frontend/assets/js/docx-preview.min.js') }}"></script>
   <!--wow js-->
   <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

   <!--main/custom js-->
   <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
   <script src="{{ asset('frontend/assets/js/player.js') }}"></script>
   <script>
document.addEventListener('DOMContentLoaded', function() {
    // Core player initialization
    const videoPlayer = videojs('vid1');
    const notyf = new Notyf({
        duration: 3000,
        position: {
            x: 'right',
            y: 'top'
        },
        types: [{
                type: 'success',
                background: '#28a745',
                duration: 3000
            },
            {
                type: 'error',
                background: '#dc3545',
                duration: 3000
            },
            {
                type: 'info',
                background: '#17a2b8',
                duration: 2000
            }
        ]
    });

    // Track video completion
    let videoCompleted = false;
    let videoTimeUpdated = false;
    const completionThreshold = 100; // 90% completion to mark as watched

    // Load and play a video function
    function loadVideo(videoId, videoPath, videoName) {
        // Reset completion tracking
        videoCompleted = false;
        videoTimeUpdated = false;

        // Update video source
        videoPlayer.src({
            type: "video/youtube",
            src: "https://youtu.be/" + videoPath
        });

        videoPlayer.poster('');
        videoPlayer.load();
        videoPlayer.play();

        // Update displayed video name
        document.querySelector('.video_heading').textContent = videoName;

        // Store current video ID for reference
        videoPlayer.currentVideoId = videoId;

        // Activate the corresponding sidebar item
        activateSidebarItem(videoId);
    }

    // Activate sidebar item for current video
    function activateSidebarItem(videoId) {
        // Remove active class from all items
        document.querySelectorAll('.video-link').forEach(link => {
            link.classList.remove('active-video');
        });

        // Add active class to current video
        const activeLink = document.querySelector(`.video-link[data-video-id="${videoId}"]`);
        if (activeLink) {
            activeLink.classList.add('active-video');

            // Expand accordion if collapsed
            const accordionBody = activeLink.closest('.accordion-collapse');
            if (accordionBody && !accordionBody.classList.contains('show')) {
                const accordionId = accordionBody.id;
                const accordionButton = document.querySelector(`[data-bs-target="#${accordionId}"]`);
                if (accordionButton) {
                    accordionButton.click();
                }
            }
        }
    }

    // Video completion handler
    function handleVideoCompletion(videoId) {
        if (videoCompleted) return;

        videoCompleted = true;
        const checkbox = document.querySelector(`.video-checkbox[data-video-id="${videoId}"]`);

        // Show spinner during processing
        const videoLabel = document.querySelector(`.video-link[data-video-id="${videoId}"]`);
        const spinner = videoLabel.querySelector('.spinner-border');
        if (spinner) spinner.classList.remove('d-none');

        if (checkbox && !checkbox.checked) {
            checkbox.checked = true;
            updateLessonCompletionStatus(videoId, true);
        }
    }

    // Send completion status to server
    function updateLessonCompletionStatus(videoId, isCompleted) {
        // Show spinner during processing
        const videoLabel = document.querySelector(`.video-link[data-video-id="${videoId}"]`);
        const spinner = videoLabel.querySelector('.spinner-border');
        if (spinner) spinner.classList.remove('d-none');

        fetch('/employee/update-lesson-completion', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf_token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    video_id: videoId,
                    is_completed: isCompleted,
                    update_progress: true // Add this flag to explicitly update overall progress
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (spinner) spinner.classList.add('d-none');

                if (data.message) {
                    notyf.success(data.message);

                    // Update progress display if returned
                    if (data.progress) {
                        updateProgressDisplay(data.progress);
                    }

                    // Handle next steps based on server response
                    handleLessonCompletionNextStep(data);
                } else if (data.error) {
                    notyf.error(data.error);
                    // Revert checkbox if there was an error
                    const checkbox = document.querySelector(
                        `.video-checkbox[data-video-id="${videoId}"]`);
                    if (checkbox) checkbox.checked = !isCompleted;
                }
            })
            .catch(error => {
                if (spinner) spinner.classList.add('d-none');

                console.error('Error:', error);
                notyf.error('Terjadi kesalahan saat menyimpan progress.');
                // Revert checkbox on error
                const checkbox = document.querySelector(`.video-checkbox[data-video-id="${videoId}"]`);
                if (checkbox) checkbox.checked = !isCompleted;
            });
    }

    // Update progress display in the header
    function updateProgressDisplay(progress) {
        if (!progress) return;

        const progressElement = document.querySelector('.wsus__course_header p');
        if (progressElement) {
            progressElement.textContent = `Your Progress: ${progress.completed_items} of ${progress.total_items} (${progress.percentage}%)`;
        }
    }

    // Handle next steps after lesson completion
    function handleLessonCompletionNextStep(data) {
        switch (data.next_step) {
            case 'quiz':
                notyf.info('Mengarahkan ke quiz...');
                setTimeout(() => {
                    window.location.href = `/employee/quiz-info/${data.quiz_id}`;
                }, 1500);
                break;

            case 'next_chapter':
                notyf.info('Mengarahkan ke chapter selanjutnya...');
                setTimeout(() => {
                    // Find first video in next chapter and play it
                    const nextChapterId = data.next_chapter_id;
                    if (nextChapterId) {
                        const nextChapterAccordion = document.querySelector(
                            `#collapse${nextChapterId}`);
                        if (nextChapterAccordion) {
                            // Expand the accordion
                            const accordionButton = document.querySelector(
                                `[data-bs-target="#collapse${nextChapterId}"]`);
                            if (accordionButton && !nextChapterAccordion.classList.contains(
                                'show')) {
                                accordionButton.click();
                            }

                            // Find first video and play it
                            setTimeout(() => {
                                const firstVideo = nextChapterAccordion.querySelector(
                                    '.video-link');
                                if (firstVideo) {
                                    const videoId = firstVideo.dataset.videoId;
                                    const videoPath = firstVideo.dataset.videoPath;
                                    const videoName = firstVideo.dataset.videoName;
                                    loadVideo(videoId, videoPath, videoName);
                                }
                            }, 500);
                        } else {
                            window.location.reload(); // Fallback: reload page
                        }
                    } else {
                        window.location.reload(); // Fallback: reload page
                    }
                }, 1500);
                break;

            case 'course_completed':
                notyf.success('Selamat! Kursus telah selesai.');
                // Could redirect to completion page or show a modal
                setTimeout(() => {
                    // Redirect to course completion or dashboard
                    window.location.href = '/employee/courses';
                }, 3000);
                break;
        }
    }

    // Event listeners

    // Video end event
    videoPlayer.on('ended', function() {
        if (videoPlayer.currentVideoId) {
            handleVideoCompletion(videoPlayer.currentVideoId);
        }
    });

    // Track video progress
    videoPlayer.on('timeupdate', function() {
        if (videoTimeUpdated || !videoPlayer.currentVideoId) return;

        const currentTime = videoPlayer.currentTime();
        const duration = videoPlayer.duration();

        if (duration > 0 && (currentTime / duration) >= completionThreshold) {
            videoTimeUpdated = true;
            handleVideoCompletion(videoPlayer.currentVideoId);
        }
    });

    // Click handler for video links
    document.querySelectorAll('.video-link').forEach(link => {
        link.addEventListener('click', function(e) {
            // Skip if clicking on locked videos
            if (this.classList.contains('video-link-locked')) {
                e.preventDefault();
                notyf.error('Selesaikan video sebelumnya terlebih dahulu.');
                return;
            }

            e.preventDefault();
            const videoId = this.dataset.videoId;
            const videoPath = this.dataset.videoPath;
            const videoName = this.dataset.videoName;
            loadVideo(videoId, videoPath, videoName);
        });
    });

    // Checkbox click handler
    document.querySelectorAll('.video-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const videoId = this.dataset.videoId;
            const isChecked = this.checked;

            // Get the associated link to check if it's locked
            const videoLink = document.querySelector(
                `.video-link[data-video-id="${videoId}"]`);
            if (videoLink && videoLink.classList.contains('video-link-locked')) {
                this.checked = false;
                notyf.error('Selesaikan video sebelumnya terlebih dahulu.');
                return;
            }

            updateLessonCompletionStatus(videoId, isChecked);
        });
    });

    // Initialize first video
    const initialVideoLink = document.querySelector('.video-link:not(.video-link-locked)');
    if (initialVideoLink) {
        const videoId = initialVideoLink.dataset.videoId;
        const videoPath = initialVideoLink.dataset.videoPath;
        const videoName = initialVideoLink.dataset.videoName;
        loadVideo(videoId, videoPath, videoName);
    }
});

</script>
</body>

</html>
