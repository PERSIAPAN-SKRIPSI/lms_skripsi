<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz: {{ $quiz->title }}</title>
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/spacing.css') }}" rel=" stylesheet">
    <link href="{{ asset('frontend/assets/css/all.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" rel="stylesheet">
    <!-- **Assuming Video.js CSS is included, if used** -->
    {{-- <link href="https://vjs.zencdn.net/7.10.2/video-js.css" rel="stylesheet"> --}}

</head>

<body>

    <!-- ================================
     START BREADCRUMB AREA
 ================================= -->
    <section class="breadcrumb-area quiz-page">
        <div class="bg-dark pt-60px pb-60px">
            <div class="container">
                <ul class="quiz-course-nav d-flex align-items-center justify-content-between">
                    <li>
                        <a class="icon-element icon-element-sm" data-toggle="tooltip" data-placement="top"
                            href="{{ route('employees-dashboard.courses.learn', $quiz->chapter->course->slug) }}"
                            title="Back to Course">
                            <i class="la la-arrow-left"></i>
                        </a>
                    </li>
                    @if(isset($videos) && count($videos) > 0) {{-- Check if $videos is set and not empty --}}
                        @foreach ($videos as $video)
                            <li>
                                <a class="icon-element icon-element-sm video-breadcrumb-link"
                                    data-video-id="{{ $video->id }}" data-video-path="{{ $video->path_video }}"
                                    data-video-name="{{ $video->name }}" data-toggle="tooltip" data-placement="top"
                                    href="javascript:void(0);" title="{{ $video->name }}"
                                    onclick="loadVideoFromBreadcrumb('{{ $video->id }}', '{{ $video->path_video }}', '{{ $video->name }}')">
                                    <i class="la la-play"></i>
                                </a>
                            </li>
                        @endforeach
                    @endif
                    <li>
                        <a class="icon-element icon-element-sm text-success" data-toggle="tooltip" data-placement="top"
                            href="#" title="Quiz: {{ $quiz->title }}">
                            <i class="la la-pencil-ruler"></i>
                        </a>
                    </li>
                </ul>
                <div class="breadcrumb-content pt-40px">
                    <div class="section-heading">
                        <h2 class="section__title text-white fs-30 pb-2">Quiz: {{ $quiz->title }}</h2>
                        <p class="section__desc text-white-50">{{ $quiz->description }}</p>
                        <p class="section__desc text-white-50">Question 1 of {{ $quiz->questions->count() }}</p>  <!-- Added Question Progress -->
                    </div>
                </div>
            </div><!-- end container -->
        </div>
        <div class="quiz-action-nav py-3 shadow-sm">
            <div class="container">
                <div class="quiz-action-content d-flex flex-wrap align-items-center justify-content-between">
                    <ul class="quiz-nav d-flex flex-wrap align-items-center">
                        <li><i class="la la-question-circle fs-17 mr-2"></i>Choose the correct answer below</li>
                        <li>
                            <span class="ml-3" id="quiz-timer" style="color: red; font-weight: bold;"></span>
                        </li>
                    </ul>
                    <div class="quiz-nav-btns">
                        <a class="btn theme-btn theme-btn-transparent mr-2"
                            href="{{ route('employees-dashboard.courses.learn', $quiz->chapter->course->slug) }}">Skip
                            Quiz</a>
                        <a class="btn theme-btn theme-btn-transparent mr-2"
                            href="{{ route('employees-dashboard.courses.learn', $quiz->chapter->course->slug) }}">Review
                            Video</a>
                        <button class="btn theme-btn" form="quiz-form" type="submit">Submit Quiz <i
                                class="la la-check icon ml-1"></i></button> {{-- Changed button text to "Submit Quiz" and icon --}}
                    </div>
                </div>
            </div><!-- end container -->
        </div><!-- end quiz-action-nav -->
    </section><!-- end breadcrumb-area -->
    <!-- ================================
     END BREADCRUMB AREA
 ================================= -->

    <!-- ================================
        START QUIZ ANS AREA
 ================================= -->
    <section class="quiz-ans-wrap pt-60px pb-60px">
        <div class="container">
            <div class="quiz-ans-content">
                <h3 class="fs-22 font-weight-semi-bold mb-3">Answer the following questions:</h3> {{-- Changed heading --}}
                <form id="quiz-form" action="{{ route('employees-dashboard.submit-quiz') }}" method="POST">
                    @csrf
                    <input name="quiz_id" type="hidden" value="{{ $quiz->id }}">
                    <div class="quiz-card-body">
                        @foreach($quiz->questions as $question)
                            <div class="quiz-question mb-4"> {{-- Added quiz-question wrapper for each question --}}
                                <p class="fs-18 font-weight-semi-bold mb-3">{{ $question->question }}</p>
                                <div class="quiz-answer-options">
                                    @foreach ($question->options as $option)
                                        <div class="quiz-answer-option">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input"
                                                    id="option-{{ $option->id }}"
                                                    name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                                                    required>
                                                <label class="custom-control-label" for="option-{{ $option->id }}">
                                                    {{ $option->option_text }}
                                                </label>
                                            </div><!-- end custom-control -->
                                        </div><!-- end quiz-answer-option -->
                                    @endforeach
                                </div><!-- end quiz-answer-options -->
                            </div><!-- end quiz-question -->
                        @endforeach
                        {{-- Removed misleading note --}}
                    </div><!-- end quiz-card-body -->
                </form>
            </div><!-- end quiz-ans-content -->
        </div><!-- end container -->
    </section>
    <!-- ================================
        START QUIZ ANS AREA
 ================================= -->

    <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- **Assuming Video.js JS is included, if used** -->
    {{-- <script src="https://vjs.zencdn.net/7.10.2/video.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#quiz-form').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        const notyf = new Notyf();

                        if (response.passed) {
                            notyf.success(response.message + " Score: " + response.score + "%");
                            window.location.href = "{{ route('employees-dashboard.quiz-results', '') }}/" +
                                response.attempt_id;
                        } else {
                            notyf.error(response.message + " Score: " + response.score +
                                "%. Passing Grade: {{ $quiz->passing_score }}%");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX request failed", status, error);
                        console.log("XHR Response:", xhr.responseText);
                        const notyf = new Notyf();
                        notyf.error('Terjadi kesalahan saat mengirimkan kuis. Silakan coba lagi.');
                    }
                });
            });

            // Quiz Timer
            const quizDurationMinutes = {{ $quiz->duration }};
            let timeLeft = quizDurationMinutes * 60;
            const timerDisplay = $('#quiz-timer');
            let timerInterval; // Declare timerInterval outside function scope

            function updateTimerDisplay() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerDisplay.text(String(minutes).padStart(2, '0') + ":" + String(seconds).padStart(2, '0')); // Corrected timer display
            }

            function startTimer() {
                updateTimerDisplay();
                timerInterval = setInterval(() => {
                    timeLeft--;
                    updateTimerDisplay();

                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        timerDisplay.text("Waktu Habis!");
                        $('#quiz-form').submit(); // Auto-submit form when time is up - **Uncomment if needed**
                    }
                }, 1000);
            }

            startTimer();

             // Function to stop timer - Add this function to make timer stoppable
             function stopTimer() {
                if (timerInterval) {
                    clearInterval(timerInterval);
                }
            }

            // Override form submit to stop timer before submission
            $('#quiz-form').on('submit', function() {
                stopTimer(); // Stop the timer when form is submitted
            });


        });

        function loadVideoFromBreadcrumb(videoId, videoPath, videoName) {
            // **Assuming Video.js player with id="vid1" is initialized elsewhere in your page**
            // Example Video.js initialization:
            // <video id="vid1" class="video-js vjs-default-skin" controls preload="auto" width="640" height="264"></video>
            var videoPlayer = videojs('vid1');
            if (videoPlayer) {
                videoPlayer.src({
                    type: 'video/youtube',
                    src: 'https://youtu.be/' + videoPath
                });
                videoPlayer.play();
            } else {
                console.error("Video.js player with id='vid1' not found.");
                alert("Video player not found. Please ensure Video.js is properly initialized.");
            }
        }
    </script>

</body>

</html>
