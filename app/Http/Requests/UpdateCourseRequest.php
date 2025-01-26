<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['owner', 'teacher']);
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
            'path_trailer' => ['required', 'string', 'max:255'],
            'about' => ['required', 'string', 'max:65535'], // Lebih panjang jika deskripsi panjang dibutuhkan
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'thumbnail' => ['sometimes', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'], // Tambahkan batas ukuran
            'course_keypoints.*' => ['required', 'string', 'max:255'],
            'price_in_coins' => ['required', 'integer', 'min:0'], // Validasi untuk bilangan positif
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The course name is required.',
            'path_trailer.required' => 'The path trailer is required.',
            'about.required' => 'The course description is required.',
            'category_id.required' => 'A category must be selected.',
            'category_id.exists' => 'The selected category does not exist.',
            'thumbnail.image' => 'The thumbnail must be an image file.',
            'thumbnail.mimes' => 'The thumbnail must be a file of type: png, jpg, jpeg, svg.',
            'thumbnail.max' => 'The thumbnail image must not be larger than 2MB.',
            'price_in_coins.required' => 'The course price in coins is required.',
            'price_in_coins.integer' => 'The course price must be an integer.',
            'price_in_coins.min' => 'The course price must be at least 0.',
        ];
    }
}
