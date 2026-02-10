<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartnerRequest extends FormRequest
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
            'user' => 'sometimes|string|max:255|unique:users,name',
            'name' => 'sometimes|max:255',
            'code' => 'sometimes|integer|digits_between:5,7',
            'partner_role_id' => 'sometimes|integer|exists:roles,id',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
