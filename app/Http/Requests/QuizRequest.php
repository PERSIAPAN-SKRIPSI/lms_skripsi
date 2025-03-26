<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['teacher']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
         'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'passing_score' => 'required|numeric|min:0',
        'duration' => 'required|numeric|min:1',
        'course_id' => 'required|exists:courses,id',
        'chapter_id' => 'required|exists:chapters,id',
        'is_active' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'passing_score.min' => 'The passing score must be at least 0%.',
            'passing_score.max' => 'The passing score cannot be more than 100%.',
            'duration.min' => 'The duration must be at least 1 minute.',
        ];
    }
}
