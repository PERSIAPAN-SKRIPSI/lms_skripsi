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
            // Ambil semua chapters untuk dropdown
            $chapters = Chapter::all();
            return view('admin.quizzes.edit', compact('quiz', 'courses', 'chapters'));
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
    public function show(Quiz $quiz)
    {
        try {
            $user = Auth::user();

            if ($user->hasRole('teacher') && $quiz->course->teacher_id !== $user->teacher->id) {
                return back()->with('error', 'Unauthorized access.');
            }

            return view('admin.quizzes.show', compact('quiz'));
        } catch (\Exception $e) {
            Log::error('Error in QuizController@show: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while viewing the quiz.');
        }
    }
    public function showQuizzesToStart()
    {
        $quizzes = Quiz::all(); // Ambil semua kuis (atau filter sesuai kebutuhan, misalnya berdasarkan course)

        return view('admin.quizzes.admin_start', compact('quizzes'));
    }

    /**
     * Memulai kuis untuk admin.
     *
     * @param  \App\Models\Quiz  $quiz
     * @return \Illuminate\Http\RedirectResponse
     */
    public function startQuiz(Quiz $quiz)
    {
        // Cari tahu apakah admin sudah pernah memulai kuis ini sebelumnya.
        $existingAttempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingAttempt) {
            // Jika sudah ada, arahkan mereka ke tampilan yang sesuai (misalnya, melanjutkan kuis atau melihat hasil).
            return redirect()->route('admin.quizzes.attempt.show', ['quiz' => $quiz->id, 'attempt' => $existingAttempt->id])
                ->with('message', 'You have already started this quiz. Continue where you left off!');
        }
        // Buat QuizAttempt baru
        $attempt = new QuizAttempt();
        $attempt->quiz_id = $quiz->id;
        $attempt->user_id = Auth::id();
        $attempt->start_time = now(); // Waktu mulai kuis
        $attempt->save();

        // Redirect ke rute yang menampilkan pertanyaan pertama
        return redirect()->route('admin.quizzes.showQuestion', ['quiz' => $quiz->id, 'id' => 1])->with('success', 'Quiz started successfully!');

    }

    public function showQuestion(Quiz $quiz, $id)
    {
        $question = $quiz->questions()->find($id);

        if (!$question) {
            return redirect()->back()->with('error', 'Pertanyaan tidak ditemukan.');
        }

        // Cari attempt aktif dari user yang sedang login
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', Auth::id())
            ->whereNull('completed_at')
            ->first();

        if (!$attempt) {
            // Jika tidak ada attempt aktif, buat baru
            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'user_id' => Auth::id(),
                'start_time' => now(),
                'status' => 'in_progress'
            ]);
        }

        return view('admin.quizzes.showQuestion', compact('quiz', 'question', 'attempt'));
    }
}
