<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'partner_id' => 'required|integer|exists:partners,id',
            'course_id' => 'required|integer|exists:courses,id',
            'period_month' => 'required|integer',
            'period_year' => 'required|integer',
        ];
    }
}
