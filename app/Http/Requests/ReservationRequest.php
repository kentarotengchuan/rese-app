<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'date' => 'required|string',
            'time' => 'required|string',
            'number' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'date.string' => '日付を入力してください',
            'time.required' => '時刻を入力してください',
            'time.string' => '時刻を入力してください',
            'number.required' => '人数を入力してください',
            'number.string' => '人数を入力してください',
        ];
    }
}
