<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        try {
            $questions = $quiz->questions()->with('options')->paginate(10);
            return view('admin.quizzes.questions.index', compact('quiz', 'questions'));
        } catch (\Exception $e) {
            Log::error('Error di QuestionController@index: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat daftar pertanyaan.');
        }
    }

    public function create(Quiz $quiz)
    {
        try {
            // Hanya perlu mengirim data quiz ke view
            return view('admin.quizzes.questions.create', compact('quiz',));
        } catch (\Exception $e) {
            Log::error('Error di QuestionController@create: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat form pembuatan pertanyaan.');
        }
    }

    public function store(Request $request, Quiz $quiz)
    {
        try {
            // Validasi input sesuai dengan form
            $request->validate([
                'question' => 'required|string',
                'question_type' => 'required|in:multiple_choice,essay',
            ]);

            DB::beginTransaction();

            // Buat pertanyaan baru sesuai dengan input form
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question' => $request->question,
                'question_type' => $request->question_type
            ]);

            DB::commit();

            return redirect()
                ->route('admin.questions.index', $quiz->id)
                ->with('success', 'Pertanyaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error di QuestionController@store: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan saat menyimpan pertanyaan.')
                ->withInput();
        }
    }

    public function edit(Quiz $quiz, Question $question)
    {
        try {
            if ($question->quiz_id !== $quiz->id) {
                return back()->with('error', 'Pertanyaan tidak ditemukan dalam quiz ini.');
            }

            return view('admin.questions.edit', compact('quiz', 'question'));
        } catch (\Exception $e) {
            Log::error('Error di QuestionController@edit: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memuat form edit pertanyaan.');
        }
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        try {
            // Validasi input
            $request->validate([
                'question' => 'required|string',
                'question_type' => 'required|in:multiple_choice,essay',
            ]);

            // Pastikan pertanyaan ada dan terkait dengan quiz yang benar
            if (!$question || $question->quiz_id !== $quiz->id) {
                return back()->with('error', 'Pertanyaan tidak ditemukan dalam quiz ini.');
            }

            DB::beginTransaction();

            // Update pertanyaan
            $question->question = $request->input('question');
            $question->question_type = $request->input('question_type');
            $question->save();

            DB::commit();

            return redirect()
                ->route('admin.questions.index', $quiz->id)
                ->with('success', 'Pertanyaan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error di QuestionController@update: ' . $e->getMessage());
            return back()
                ->with('error', 'Terjadi kesalahan saat memperbarui pertanyaan.')
                ->withInput();
        }
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        try {
            if ($question->quiz_id !== $quiz->id) {
                return back()->with('error', 'Pertanyaan tidak ditemukan dalam quiz ini.');
            }

            DB::beginTransaction();
            $question->delete();
            DB::commit();

            return redirect()
                ->route('admin.questions.index', $quiz->id)
                ->with('success', 'Pertanyaan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error di QuestionController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menghapus pertanyaan.');
        }
    }

    public function show(Quiz $quiz, Question $question)
    {
        // Logika untuk menampilkan detail pertanyaan
        return view('admin.questions.show', compact('quiz', 'question'));
    }
}
