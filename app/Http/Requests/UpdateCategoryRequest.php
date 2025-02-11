<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
// app/Http/Requests/UpdateCategoryRequest.php
public function authorize(): bool
{
    return $this->user()->hasAnyRole(['admin', 'teacher']); // Corrected roles
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'icon_file' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg'],
            'icon_url' => ['nullable', 'url'],
            'image_file' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg'],
            'image_url' => ['nullable', 'url'],
            'parent_id' => 'nullable|exists:categories,id'
        ];
    }
}
