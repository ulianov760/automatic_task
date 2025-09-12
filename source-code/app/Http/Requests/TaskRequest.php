<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
                Rule::unique('tasks', 'name')->ignore(request()->id)
            ],
            'description' => [
                'required',
                'string',
                'min:2',
            ],
            'priority_id' => [
                'required',
            ],
            'author_id' => [
                'required',
            ],
            'executor_id' => [
                'required',
            ],
            'group_id' => [
                'required',
            ],
            'status_id' => [
                'required',
            ],
        ];
    }
}
