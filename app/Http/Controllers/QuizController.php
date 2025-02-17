<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();

            if ($user->hasRole('teacher')) {
                $quizzes = Quiz::whereHas('course', function ($query) use ($user) {
                    $query->where('teacher_id', $user->teacher->id);
                })->with(['course', 'chapter'])->paginate(10);
            } else {
                $quizzes = Quiz::with(['course', 'chapter'])->paginate(10);
            }

            // Fetch all courses
            $courses = Course::all();

            return view('admin.quizzes.index', compact('quizzes', 'courses'));
        } catch (\Exception $e) {
            Log::error('Error in QuizController@index: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading quizzes.');
        }
    }

    public function create()
    {
        try {
            $user = Auth::user();

            if ($user->hasRole('teacher')) {
                $courses = Course::where('teacher_id', $user->teacher->id)->with('chapters')->get();
            } else {
                $courses = Course::with('chapters')->get();
            }

            // Ambil semua chapters untuk dropdown
            $chapters = Chapter::all();

            return view('admin.quizzes.create', compact('courses', 'chapters'));
        } catch (\Exception $e) {
            Log::error('Error in QuizController@create: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the create quiz form.');
        }
    }

    public function store(QuizRequest $request)
    {
        try {
            DB::beginTransaction();

            $quiz = Quiz::create([
                'course_id' => $request->course_id,
                'chapter_id' => $request->chapter_id,
                'title' => $request->title,
                'description' => $request->description,
                'passing_score' => $request->passing_score,
                'duration' => $request->duration,
                'is_active' => $request->is_active ?? false
            ]);

            DB::commit();
            // Arahkan ke halaman index pertanyaan setelah kuis berhasil dibuat
            return redirect()->route('admin.quizzes.questions.index', $quiz->id)
                ->with('success', 'Quiz created successfully. Now add some questions!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in QuizController@store: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while creating the quiz.');
        }
    }

    public function edit(Quiz $quiz)
    {
        try {
            $user = Auth::user();

            if ($user->hasRole('teacher') && $quiz->course->teacher_id !== $user->teacher->id) {
                return back()->with('error', 'Unauthorized access.');
            }

            $courses = Course::with('chapters')->get();
            return view('admin.quizzes.edit', compact('quiz', 'courses'));
        } catch (\Exception $e) {
            Log::error('Error in QuizController@edit: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the edit quiz form.');
        }
    }

    public function update(QuizRequest $request, Quiz $quiz)
    {
        try {
            DB::beginTransaction();

            $quiz->update([
                'course_id' => $request->course_id,
                'chapter_id' => $request->chapter_id,
                'title' => $request->title,
                'description' => $request->description,
                'passing_score' => $request->passing_score,
                'duration' => $request->duration,
                'is_active' => $request->is_active ?? false
            ]);

            DB::commit();
            return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in QuizController@update: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the quiz.');
        }
    }

    public function destroy(Quiz $quiz)
    {
        try {
            $user = Auth::user();

            if ($user->hasRole('teacher') && $quiz->course->teacher_id !== $user->teacher->id) {
                return back()->with('error', 'Unauthorized access.');
            }

            $quiz->delete();
            return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in QuizController@destroy: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the quiz.');
        }
    }
}
