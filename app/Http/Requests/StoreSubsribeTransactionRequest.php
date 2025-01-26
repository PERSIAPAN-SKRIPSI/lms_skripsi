<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubsribeTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow authenticated users to make this request
        return $this->user()->hasAnyRole(['karyawan']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'poin_amount' => ['required', 'numeric', 'min:1'],
            'subscription_start_date' => ['required', 'date', 'after_or_equal:today'],
            'subscription_end_date' => ['required', 'date', 'after:subscription_start_date'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'course_id' => 'Course',
            'poin_amount' => 'Point Amount',
            'subscription_start_date' => 'Subscription Start Date',
            'subscription_end_date' => 'Subscription End Date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'course_id.required' => 'Please select a course',
            'course_id.exists' => 'The selected course is invalid',
            'poin_amount.required' => 'Point amount is required',
            'poin_amount.numeric' => 'Point amount must be a number',
            'poin_amount.min' => 'Point amount must be at least 1',
            'subscription_start_date.required' => 'Subscription start date is required',
            'subscription_start_date.date' => 'Invalid start date format',
            'subscription_start_date.after_or_equal' => 'Start date must be today or later',
            'subscription_end_date.required' => 'Subscription end date is required',
            'subscription_end_date.date' => 'Invalid end date format',
            'subscription_end_date.after' => 'End date must be after start date',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'subscription_start_date' => now()->toDateString(),
            'subscription_end_date' => now()->addMonths(1)->toDateString(), // Default 1 month subscription
            'is_paid' => false,
            'purchase_date' => now(),
        ]);
    }
}
