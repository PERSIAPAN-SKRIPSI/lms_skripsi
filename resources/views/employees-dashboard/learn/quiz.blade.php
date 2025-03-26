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

    <style>
        #quiz-timer {
            font-family: 'Courier New', Courier, monospace;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .question-item {
            display: none; /* Hide all question items by default */
        }

        .question-item.active {
            display: block; /* Show the active question item */
        }
    </style>

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
                    <li>
                        <a class="icon-element icon-element-sm text-success" data-toggle="tooltip" data-placement="top"
                            title="Quiz: {{ $quiz->title }}">
                            <i class="la la-pencil-ruler"></i>
                        </a>
                    </li>
                </ul>
                <div class="breadcrumb-content pt-40px">
                    <div class="section-heading">
                        <h2 class="section__title text-white fs-30 pb-2">Quiz: {{ $quiz->title }}</h2>
                        <p class="section__desc text-white-50">{{ $quiz->description }}</p>
                        <p class="section__desc text-white-50">Pertanyaan <span id="current-question-number">1</span> dari <span id="total-questions">{{ $quiz->questions->count() }}</span></p>
                    </div>
                </div>
            </div><!-- end container -->
        </div>
        <div class="quiz-action-nav py-3 shadow-sm">
            <div class="container">
                <div class="quiz-action-content d-flex flex-wrap align-items-center justify-content-between">
                    <ul class="quiz-nav d-flex flex-wrap align-items-center">
                        <li><i class="la la-question-circle fs-17 mr-2"></i>Pilih jawaban yang paling tepat di bawah ini</li>
                        <li>
                            <span class="ml-3" id="quiz-timer" style="color: red; font-weight: bold;"></span>
                        </li>
                    </ul>
                    <div class="quiz-nav-btns">
                        <a class="btn theme-btn theme-btn-transparent mr-2"
                            href="{{ route('employees-dashboard.courses.learn', $quiz->chapter->course->slug) }}">Lewati
                            Quiz</a>
                        <a class="btn theme-btn theme-btn-transparent mr-2"
                            href="{{ route('employees-dashboard.courses.learn', $quiz->chapter->course->slug) }}">Review
                            Video</a>
                        <button class="btn theme-btn" form="quiz-form" type="submit">Kumpulkan Quiz <i
                                class="la la-check icon ml-1"></i></button>
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
                <h3 class="fs-22 font-weight-semi-bold mb-3">Jawab pertanyaan-pertanyaan berikut:</h3>
                <form id="quiz-form" action="{{ route('employees-dashboard.submit-quiz') }}" method="POST">
                    @csrf
                    <input name="quiz_id" type="hidden" value="{{ $quiz->id }}">
                    <div class="quiz-card-body">
                        @foreach($quiz->questions as $index => $question)
                            <div class="quiz-question question-item mb-4" data-question-index="{{ $index }}">
                                <p class="fs-18 font-weight-semi-bold mb-3">
                                    {{ $index + 1 }}. {{ $question->question }}
                                </p>
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
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="quiz-navigation d-flex justify-content-between mt-4">
                        <button type="button" class="btn theme-btn-transparent" id="prev-question" disabled>
                            <i class="la la-arrow-left icon mr-1"></i> Sebelumnya
                        </button>
                        <button type="button" class="btn theme-btn" id="next-question">
                            Selanjutnya <i class="la la-arrow-right icon ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- ================================
        START QUIZ ANS AREA
 ================================= -->

    <script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        (function() {

            $(document).ready(function() {
                const quizForm = $('#quiz-form');
                const timerDisplay = $('#quiz-timer');
                const quizDurationMinutes = {{ $quiz->duration }};
                let timerInterval;
                const endTimeStorageKey = 'quizEndTime';
                const questionItems = $('.question-item');
                const prevButton = $('#prev-question');
                const nextButton = $('#next-question');
                const currentQuestionNumberDisplay = $('#current-question-number');
                const totalQuestions = questionItems.length;
                let currentQuestionIndex = 0; // Start at the first question (index 0)

                // --- Timer Functions (No changes needed here, assuming they are correct) ---
                function updateDisplay(remainingTimeInSeconds) {
                    const minutes = Math.floor(remainingTimeInSeconds / 60);
                    const seconds = remainingTimeInSeconds % 60;
                    timerDisplay.text(`${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`);
                }

                function handleTimeOut() {
                    clearInterval(timerInterval);
                    timerDisplay.text("Waktu Habis!");
                    clearStoredEndTime();
                    
                    quizForm.submit();
                }

                function clearStoredEndTime() {
                    sessionStorage.removeItem(endTimeStorageKey);
                }

                function stopTimer() {
                    if (timerInterval) {
                        clearInterval(timerInterval);
                    }
                }

                function startTimerInterval() {
                    timerInterval = setInterval(() => {
                        let timeLeft = getRemainingTime();
                        if (timeLeft <= 0) {
                            handleTimeOut();
                        } else {
                            updateDisplay(timeLeft);
                        }
                    }, 1000);
                }

                function getRemainingTime() {
                    const storedEndTime = sessionStorage.getItem(endTimeStorageKey);
                    if (storedEndTime) {
                        return Math.max(0, Math.ceil((new Date(storedEndTime) - new Date()) / 1000));
                    }
                    return quizDurationMinutes * 60;
                }

                function initializeTimer() {
                    let initialTimeLeft = getRemainingTime();

                    if (sessionStorage.getItem(endTimeStorageKey) && initialTimeLeft <= 0) {
                        updateDisplay(0);
                        timerDisplay.text("Waktu Habis!");
                        clearStoredEndTime();
                        return;
                    }

                    if (!sessionStorage.getItem(endTimeStorageKey)) {
                        const endTime = new Date(new Date().getTime() + quizDurationMinutes * 60 * 1000).toISOString();
                        sessionStorage.setItem(endTimeStorageKey, endTime);
                    }

                    updateDisplay(initialTimeLeft);
                    startTimerInterval();
                }

                // --- Question Navigation Functions ---
                function showQuestion(index) {
                    if (index >= 0 && index < totalQuestions) { // Check if index is valid
                        questionItems.removeClass('active').hide(); // Hide all questions and remove active class
                        questionItems.eq(index).addClass('active').show(); // Show the question at the index and add active class
                        currentQuestionIndex = index; // Update the current question index
                        currentQuestionNumberDisplay.text(currentQuestionIndex + 1); // Update question number display
                        updateNavigationButtons(); // Update navigation button states
                    } else {
                        console.error("Index pertanyaan di luar batas:", index); // Log error if index is invalid
                    }
                }

                function updateNavigationButtons() {
                    prevButton.prop('disabled', currentQuestionIndex === 0); // Disable "Previous" on the first question
                    nextButton.prop('disabled', currentQuestionIndex === totalQuestions - 1); // Disable "Next" on the last question
                }

                // --- Event Listeners for Navigation Buttons ---
                nextButton.click(function() {
                    showQuestion(currentQuestionIndex + 1); // Move to the next question
                });

                prevButton.click(function() {
                    showQuestion(currentQuestionIndex - 1); // Move to the previous question
                });

                // --- Form Submit Handler (No changes needed here, assuming it's correct) ---
                quizForm.submit(function(e) {
                    e.preventDefault();
                    stopTimer();
                    const formData = $(this).serialize();

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            const notyf = new Notyf();
                            clearStoredEndTime();

                            if (response.passed) {
                                notyf.success(response.message + " Score: " + response.score + "%");
                                window.location.href = "{{ route('employees-dashboard.quiz-results', '') }}/" + response.attempt_id;
                            } else {
                                notyf.error(response.message + " Score: " + response.score + "%. Passing Grade: {{ $quiz->passing_score }}%");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX request failed", status, error);
                            console.log("XHR Response:", xhr.responseText);
                            const notyf = new Notyf();
                            notyf.error('Terjadi kesalahan saat mengirimkan kuis. Silakan coba lagi.');
                            clearStoredEndTime();
                        }
                    });
                });

                // --- Initialization ---
                initializeTimer(); // Initialize the timer
                showQuestion(currentQuestionIndex); // Show the first question on page load


            }); // end document ready

            function loadVideoFromBreadcrumb(videoId, videoPath, videoName) {
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

        })();
    </script>
</body>

</html>
