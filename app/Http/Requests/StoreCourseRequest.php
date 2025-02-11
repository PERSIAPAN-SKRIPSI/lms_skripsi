<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'teacher_id' => 'required|exists:teachers,id',
            'about' => 'required|string',
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
                'mimes:mp4,mov,ogg,qt,avi', // Added avi
                'max:2048000' // 2GB (in KB)
            ],
            'duration' => 'nullable|string',
            'course_keypoints' => 'nullable|array',
            'course_keypoints.*' => 'nullable|string',
            'path_trailer' => 'nullable|string',
        ];
    }

     // OPTIONAL: Custom error messages
     public function messages()
     {
          return[
            'demo_video_source.required_if' => 'A Video source is required',
            'demo_video_source_file.required_if' =>'Please Upload your video'
          ];
     }
}
