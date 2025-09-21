<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageModifyRequest extends FormRequest
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
            'modify_image' => ['mimes:png, jpeg'],
        ];
    }

    public function messages()
    {
        return [
            'modify_image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
