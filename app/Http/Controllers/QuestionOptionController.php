<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionOptionController extends Controller
{
    public function index(Quiz $quiz, Question $question)
    {
        $options = $question->options()->get();
        return view('admin.quizzes.questions.options.index', compact('quiz', 'question', 'options'));
    }

    public function create(Quiz $quiz, Question $question)
    {
        return view('admin.quizzes.questions.options.create', compact('quiz', 'question'));
    }

    public function store(Request $request, Quiz $quiz, Question $question)
    {
        if ($question->question_type === 'essay') {
            // Validasi untuk essay (mungkin tidak ada validasi khusus)
            $validatedData = $request->validate([
                'option_text' => 'nullable|string', // Teks bisa kosong karena essay dinilai manual
                'is_correct' => 'nullable|boolean',//Opsi essay harus diubah menjadi nullable
            ]);

            try {
                // Untuk essay, kita mungkin tidak menyimpan "option" sebenarnya, tapi kita bisa menyimpan catatan
                $question->options()->create($validatedData);

                return redirect()->route('admin.questions.index', [$quiz->id])//arahkan ke pertanyaan index
                    ->with('success', 'Pertanyaan Essay berhasil ditambahkan.');
            } catch (\Exception $e) {
                Log::error('Gagal menambahkan opsi pertanyaan essay: ' . $e->getMessage());
                return back()->with('error', 'Gagal menambahkan pertanyaan essay. Silakan coba lagi.')->withInput();
            }
        } elseif ($question->question_type === 'multiple_choice') {
            $validatedData = $request->validate([
                'option_text' => 'required|string',
                'is_correct' => 'required|boolean',
            ]);

            try {
                $question->options()->create($validatedData);
                return redirect()->route('admin.quizzes.questions.options.index', [$quiz->id, $question->id])
                    ->with('success', 'Opsi berhasil ditambahkan.');
            } catch (\Exception $e) {
                Log::error('Gagal menambahkan opsi pertanyaan: ' . $e->getMessage());
                return back()->with('error', 'Gagal menambahkan opsi pertanyaan. Silakan coba lagi.')->withInput();
            }
        } else {
            abort(400, 'Tipe soal tidak dikenal.');
        }
    }


    public function show(Quiz $quiz, Question $question, QuestionOption $option)
    {
        return view('admin.quizzes.questions.options.show', compact('quiz', 'question', 'option'));
    }

    public function edit(Quiz $quiz, Question $question, QuestionOption $option)
    {
        return view('admin.quizzes.questions.options.edit', compact('quiz', 'question', 'option'));
    }

    public function update(Request $request, Quiz $quiz, Question $question, QuestionOption $option)
    {
        // Validasi untuk multiple choice
        $validatedData = $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            $option->update($validatedData);

            DB::commit();

            return redirect()->route('admin.quizzes.questions.options.index', [$quiz->id, $question->id])->with('success', 'Opsi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui opsi pertanyaan: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui opsi pertanyaan. Silakan coba lagi.')->withInput();
        }
    }


    public function destroy(Quiz $quiz, Question $question, QuestionOption $option)
    {
        try {
            $option->delete();
            return redirect()->route('admin.quizzes.questions.options.index', [$quiz->id, $question->id])->with('success', 'Opsi berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus opsi pertanyaan: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus opsi pertanyaan. Silakan coba lagi.');
        }
    }
}
