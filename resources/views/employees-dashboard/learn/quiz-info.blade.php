<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Information: {{ $quiz->title }}</title>
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/spacing.css') }}" rel=" stylesheet">
    <link href="{{ asset('frontend/assets/css/all.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .quiz-info-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 30px;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .quiz-info-header {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .quiz-info-title {
            font-size: 28px;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 10px;
        }
        .quiz-info-description {
            color: #6c757d;
            font-size: 16px;
        }
        .quiz-info-details {
            margin-top: 20px;
            font-size: 16px;
        }
        .quiz-info-details p {
            margin-bottom: 8px;
        }
        .start-quiz-button {
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .quiz-info-container {
                padding: 20px;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .quiz-info-title {
                font-size: 24px;
            }
            .quiz-info-description {
                font-size: 15px;
            }
            .quiz-info-details {
                font-size: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="quiz-info-container">
        <div class="quiz-info-header">
            <h1 class="quiz-info-title">{{ $quiz->title }}</h1>
            <p class="quiz-info-description">{{ $quiz->description }}</p>
        </div>

        <div class="quiz-info-details">
            <p><i class="la la-question-circle mr-2"></i> <strong>Number of Questions:</strong> {{ $quiz->questions_count }}</p>
            <p><i class="la la-clock-o mr-2"></i> <strong>Duration:</strong> {{-- You can add duration logic here if needed --}} {{-- Example: 30 Minutes --}}  {{-- or fetch from quiz settings --}}</p>
            <p><i class="la la-check-double mr-2"></i> <strong>Passing Score:</strong> {{ $quiz->passing_score }}%</p>
            {{-- Add more quiz info here if needed --}}
        </div>

        <div class="start-quiz-button">
            <a href="{{ route('employees-dashboard.get-quiz', $quiz->id) }}" class="btn theme-btn">Start Quiz <i class="la la-arrow-right ml-1"></i></a>
            <a href="{{ route('employees-dashboard.courses.learn', $quiz->chapter->course->slug) }}" class="btn theme-btn theme-btn-transparent ml-2">Back to Course</a>
        </div>
    </div>
</div>

<script src="{{ asset('frontend/assets/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>

</body>
</html>
