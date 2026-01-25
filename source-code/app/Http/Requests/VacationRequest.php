<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VacationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:250',
                Rule::unique('settlements', 'name')->ignore(request()->id)
            ],
//            'employee_id' => [
//                'required',
//            ],
            'status_id' => [
                'required',
            ],
            'date_start' => [
                'required',
            ],
            'date_finish' => [
                'required',
            ],
        ];
    }
}
