<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionOptionController extends Controller
{
    /**
     * Display a listing of the question options for a specific question.
     */
    public function index(Quiz $quiz, Question $question)
    {
        $options = $question->options()->get();
        return view('admin.quizzes.questions.options.index', compact('quiz', 'question', 'options'));
    }

    /**
     * Show the form for creating a new question option for a specific question.
     */
    public function create(Quiz $quiz, Question $question)
    {
        return view('admin.quizzes.questions.options.create', compact('quiz', 'question'));
    }

    /**
     * Store a newly created question option in storage.
     */
    public function store(Request $request, Quiz $quiz, Question $question)
    {
        $validatedData = $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        try {
            $question->options()->create($validatedData);
            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('admin.quizzes.questions.options.index', [$quiz->id, $question->id])
                ->with('success', 'Opsi berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan opsi pertanyaan: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan opsi pertanyaan. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Display the specified question option.
     */
    public function show(Quiz $quiz, Question $question, QuestionOption $option)
    {
        return view('admin.quizzes.questions.options.show', compact('quiz', 'question', 'option'));
    }

    /**
     * Show the form for editing the specified question option.
     */
    public function edit(Quiz $quiz, Question $question, QuestionOption $option)
    {
        return view('admin.quizzes.questions.options.edit', compact('quiz', 'question', 'option'));
    }

    /**
     * Update the specified question option in storage.
     */
    public function update(Request $request, Quiz $quiz, Question $question, QuestionOption $option)
    {
        $validatedData = $request->validate([
            'option_text' => 'required|string',
            'is_correct' => 'required|boolean',
        ]);

        try {
            $option->update($validatedData);
            return redirect()->route('admin.quizzes.questions.options.index', [$quiz->id, $question->id])->with('success', 'Opsi berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui opsi pertanyaan: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui opsi pertanyaan. Silakan coba lagi.')->withInput();
        }
    }

    /**
     * Remove the specified question option from storage.
     */
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
