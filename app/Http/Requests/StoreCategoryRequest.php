<?php

// StoreCategoryRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['admin', 'teacher']);
    }

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

    protected function prepareForValidation()
    {
        if (!$this->hasFile('icon_file') && !$this->filled('icon_url')) {
            $this->merge(['icon_required' => true]);
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (isset($this->icon_required)) {
                $validator->errors()->add('icon', 'Icon wajib diisi (file atau URL).');
            }
        });
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.string' => 'Nama kategori harus berupa teks.',
            'name.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'icon_file.image' => 'Icon harus berupa gambar.',
            'icon_file.mimes' => 'Icon harus berupa format png, jpg, jpeg, atau svg.',
            'icon_url.url' => 'URL icon tidak valid.',
            'image_file.image' => 'Image harus berupa gambar.',
            'image_file.mimes' => 'Image harus berupa format png, jpg, jpeg, atau svg.',
            'image_url.url' => 'URL image tidak valid.',
        ];
    }
}
