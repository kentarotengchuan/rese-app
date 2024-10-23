<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'name' => 'required|max:20',
            'area' => 'required|max:20',
            'genre' => 'required|max:20',
            'description' => 'max:300'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店名を入力してください',
            'name.max' => '店名は20文字以内で入力してください',
            'area.required' => '地域名を入力してください',
            'area.max' => '地域名は20文字以内で入力してください',
            'genre.required' => 'ジャンル名を入力してください',
            'genre.max' => 'ジャンル名は20文字以内で入力してください',
            'description.max' => '説明文は300文字以内で入力してください',
        ];
    }
}
