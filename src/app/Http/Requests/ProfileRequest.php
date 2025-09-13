<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'image' => ['mimes:png, jpeg'],
            'postal_code' => ['regex:/^[0-9]{3}-[0-9]{4}$/'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'postal_code.regex' => '郵便番号は123-4567の形で入力してください',
        ];
    }
}
