<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
        $rules = [
            'quiz_id' => ['required', 'exists:quizzes,id'],
            'question' => ['required', 'string', 'max:1000'],
            'question_type' => ['required', 'in:multiple_choice,true_false,short_answer'],
        ];

        // Add validation rules for options if question type is multiple choice
        if ($this->input('question_type') === 'multiple_choice') {
            $rules['options'] = ['required', 'array', 'min:2'];
            $rules['options.*'] = ['required', 'string', 'max:255'];
            $rules['correct_option'] = ['required', 'integer', 'min:0', 'lt:' . count($this->input('options', []))];
        }

        // Add validation rules for true/false
        if ($this->input('question_type') === 'true_false') {
            $rules['correct_option'] = ['required', 'boolean'];
        }

        // Add validation rules for short answer
        if ($this->input('question_type') === 'short_answer') {
            $rules['correct_answer'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'options.required' => 'At least two options are required for multiple choice questions.',
            'options.min' => 'Multiple choice questions must have at least two options.',
            'options.*.required' => 'All options must have content.',
            'correct_option.lt' => 'The correct option must be one of the provided options.',
            'correct_answer.required' => 'The correct answer is required for short answer questions.',
        ];
    }
}
