<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeesCreateRequest extends FormRequest
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
            'fio' => [
                'required',
                'string',
                'min:5',
                'max:250',
            ],
            'age' => [
                'required',
                'integer',
                'min:18',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('employees', 'email')->ignore(request()->id)
                ],
            'password' =>  [
                'required',
                'string',
                'min:8',
            ],
            'post_id' => [
                'required',
            ],
            'team_id' => [
                'required',
            ],
        ];
    }
}
