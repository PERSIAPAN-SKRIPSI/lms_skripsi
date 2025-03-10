<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Quiz: {{ $quizAttempt->quiz->title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Breadcrumb Area -->
    <section class="bg-gray-100 py-3">
        <div class="container mx-auto px-4">
            <div class="bg-white py-3 rounded-md shadow-sm">
                <div class="container mx-auto px-4">
                    <div class="flex justify-between items-center">
                        <ul class="quiz-nav flex flex-wrap items-center space-x-4">
                            <li>
                                <a href="{{ route('employees-dashboard.courses.learn', $quizAttempt->quiz->chapter->course->slug) }}"
                                   class="text-blue-500 hover:text-blue-700 transition-colors duration-200">
                                    <i class="la la-arrow-left mr-2"></i>Back to Course
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Score and Title Area -->
    <section class="bg-gray-800 py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="section-heading">
                <p class="text-gray-300 text-lg mb-2">Submitted on {{ $quizAttempt->completed_at->format('d F Y') }}</p>
                <h2 class="text-white text-4xl font-bold mb-6">Your Score: <span class="text-green-400">{{ number_format($quizAttempt->score, 0) }}/100</span></h2>
            </div>
            <div class="breadcrumb-btn-box space-x-4 mt-8">
                @if ($canRestartQuiz)
                    <a href="{{ route('employees-dashboard.restart-quiz', $quizAttempt->quiz->id) }}"
                       class="bg-transparent hover:bg-blue-500 text-white font-semibold hover:text-white py-2 px-6 border border-white hover:border-transparent rounded transition-colors duration-300">
                        Restart Quiz
                    </a>
                @endif
                <a href="{{ route('employees-dashboard.quiz-results', $quizAttempt->id) }}"
                   class="bg-transparent hover:bg-blue-500 text-white font-semibold hover:text-white py-2 px-6 border border-white hover:border-transparent rounded transition-colors duration-300">
                    View Attended Quiz
                </a>
            </div>
        </div>
    </section>

    <!-- Quiz Action Nav -->
    <section class="bg-white py-4 shadow-md border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="quiz-action-content flex flex-wrap items-center justify-between">
                <ul class="quiz-nav flex flex-wrap items-center space-x-8">
                    <li class="flex items-center">
                        <i class="la la-check-circle text-xl text-green-500 mr-2"></i>
                        <span>Score: <span class="font-semibold">{{ number_format($quizAttempt->score, 0) }}/100</span></span>
                    </li>
                    <li class="flex items-center">
                        <i class="la la-clock text-xl text-blue-500 mr-2"></i>
                        <span>Duration: <span class="font-semibold">{{ $quizAttempt->quiz->duration }} minutes</span></span>
                    </li>
                    <li class="flex items-center">
                        <i class="la la-bar-chart text-xl text-purple-500 mr-2"></i>
                        <span>Status: <span class="font-semibold">{{ $quizAttempt->status == 'passed' ? 'Passed' : 'Failed' }}</span></span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Quiz Answer Area -->
    <section class="quiz-ans-wrap py-12">
        <div class="container mx-auto px-4">
            <div class="quiz-ans-content bg-white rounded-lg shadow-lg p-8">
                @foreach ($quizAttempt->quiz->questions as $question)
                    <div class="quiz-question mb-8 pb-4 border-b border-gray-200 last:border-b-0">
                        <div class="flex items-center mb-4">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-700 font-bold mr-3">
                                {{ $loop->iteration }}
                            </span>
                            <h3 class="text-xl font-semibold text-gray-800">Question {{ $loop->iteration }} of {{ $quizAttempt->quiz->questions->count() }}</h3>
                        </div>
                        <p class="text-gray-700 leading-relaxed">{{ $question->question }}</p>
                        <ul class="quiz-result-list mt-4 pl-5 list-none">
                            @foreach ($question->options as $option)
                                <li class="text-gray-800 mb-2 flex items-start">
                                    @php
                                        $userAnsweredCorrectly = false;
                                        if (isset($quizAttempt->quizAnswers) && !$quizAttempt->quizAnswers->isEmpty()) {
                                            foreach ($quizAttempt->quizAnswers as $answer) {
                                                if ($answer->question_id == $question->id && $answer->option_id == $option->id && $option->is_correct) {
                                                    $userAnsweredCorrectly = true;
                                                    break;
                                                }
                                            }
                                        }
                                        $isUserSelected = false;
                                        if (isset($quizAttempt->quizAnswers) && !$quizAttempt->quizAnswers->isEmpty()) {
                                            foreach ($quizAttempt->quizAnswers as $answer) {
                                                if ($answer->question_id == $question->id && $answer->option_id == $option->id) {
                                                    $isUserSelected = true;
                                                    break;
                                                }
                                            }
                                        }
                                    @endphp
                                    @if ($option->is_correct)
                                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-green-100 text-green-700 mr-2 mt-0.5">
                                            <i class="la la-check text-sm"></i>
                                        </span>
                                    @elseif ($isUserSelected && !$option->is_correct)
                                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-red-100 text-red-700 mr-2 mt-0.5">
                                            <i class="la la-times text-sm"></i>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center h-5 w-5 rounded-full border border-gray-300 text-gray-700 mr-2 mt-0.5">
                                            {{ chr(65 + $loop->index) }}
                                        </span>
                                    @endif

                                    <span class="flex-1">
                                        {{ $option->option_text }}
                                        @if ($option->is_correct && $isUserSelected)
                                            <span class="text-green-600 font-semibold ml-1">(Your Correct Answer)</span>
                                        @elseif (!$option->is_correct && $isUserSelected)
                                            <span class="text-red-600 font-semibold ml-1">(Your Incorrect Answer)</span>
                                        @elseif ($option->is_correct)
                                            <span class="text-green-600 font-semibold ml-1">(Correct Answer)</span>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


</body>
</html>
