<?php

// UpdateSubCategoryRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['teacher', 'admin']);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon_url' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama sub-kategori wajib diisi.',
            'name.string' => 'Nama sub-kategori harus berupa teks.',
            'name.max' => 'Nama sub-kategori tidak boleh lebih dari 255 karakter.',
            'icon_file.image' => 'Icon harus berupa gambar.',
            'icon_file.mimes' => 'Icon harus berupa format jpeg, png, jpg, gif, atau svg.',
            'icon_file.max' => 'Ukuran icon tidak boleh lebih dari 2MB.',
            'icon_url.url' => 'URL icon tidak valid.',
            'image_file.image' => 'Image harus berupa gambar.',
            'image_file.mimes' => 'Image harus berupa format jpeg, png, jpg, gif, atau svg.',
            'image_file.max' => 'Ukuran image tidak boleh lebih dari 2MB.',
            'image_url.url' => 'URL image tidak valid.',
        ];
    }
}
