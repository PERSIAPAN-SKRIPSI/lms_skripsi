<?php

// TeacherRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['admin']);
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // 2MB max
            'certificate' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpeg,png,jpg', 'max:5120'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'is_active' => ['boolean']
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.image' => 'The avatar must be an image file.',
            'avatar.mimes' => 'The avatar must be a file of type: jpeg, png, jpg.',
            'avatar.max' => 'The avatar must not be greater than 2MB.',
        ];
    }
}
