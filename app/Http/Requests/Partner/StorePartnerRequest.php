<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class StorePartnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user' => 'required|string|max:255|unique:users,name',
            'name' => 'required|string|max:255',
            'code' => 'required|integer|digits_between:5,7',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }
}
