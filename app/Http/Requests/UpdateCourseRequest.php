<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['admin', 'teacher']);
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
            'thumbnail' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'teacher_id' => ['required', 'integer', 'exists:teachers,id'],
            'about' => ['required', 'string'],
            'demo_video_storage' => ['required', Rule::in(['upload', 'youtube', 'external_link'])],
            'demo_video_source' => [
                'required_if:demo_video_storage,youtube,external_link',
                'nullable',
                'string',   
            ],
            'demo_video_source_file' => [
                'required_if:demo_video_storage,upload',
                'nullable',
                'file',
                'mimes:mp4,mov,ogg,qt,avi',
                'max:2048000'
            ],
            'duration' => ['nullable', 'string'],
            'course_keypoints' => ['nullable', 'array'],
            'course_keypoints.*' => ['nullable', 'string', 'max:255'],
            'path_trailer' => ['nullable', 'string'], // Added path_trailer
            'description' => ['nullable','string'],
        ];
    }
        /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // Convert empty strings to null for nullable fields.
        $this->merge([
            'path_trailer' => $this->path_trailer === '' ? null : $this->path_trailer,
            'duration' => $this->duration === '' ? null : $this->duration,
             'description' => $this->description === '' ? null : $this->description,
        ]);
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The course name is required.',
            'about.required' => 'The course description is required.',
            'category_id.required' => 'A category must be selected.',
            'category_id.exists' => 'The selected category does not exist.',
            'teacher_id.required' => 'A teacher must be selected.',
            'teacher_id.exists' => 'The selected teacher does not exist.',
            'thumbnail.image' => 'The thumbnail must be an image file.',
            'thumbnail.mimes' => 'The thumbnail must be a file of type: png, jpg, jpeg, svg.',
            'thumbnail.max' => 'The thumbnail image must not be larger than 2MB.',
            'demo_video_storage.required' => 'A demo video storage type must be selected.',
            'demo_video_storage.in' => 'Invalid demo video storage type.',
            'demo_video_source.required_if' => 'The demo video source is required when using YouTube or an external link.',
            'demo_video_source_file.required_if' => 'The demo video file is required when uploading a video.',
            'demo_video_source_file.mimes' => 'The demo video file must be a file of type: mp4, mov, ogg, qt, avi.',
            'demo_video_source_file.max' => 'The demo video file must not be larger than 2GB.',
            // Add custom messages for other fields as needed
        ];
    }
}
