<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
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
                'after_or_equal:' . now()->addWeeks(2)->format('Y-m-d'),
            ],
            'date_finish' => [
                'required',
                'after_or_equal:date_start',
               'before_or_equal:' . Carbon::parse($this->date_start)->addDays(14)->format('Y-m-d'),
            ],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date_finish.after_or_equal' => 'Дата завершения отпуска не может быть меньше даты создания.',
            'date_finish.before_or_equal' => 'Отпуск невозможно взять больше 14 дней (за раз)',
            'date_start.after_or_equal' => 'Отпуск берется за 14 дней',
        ];
    }
}
