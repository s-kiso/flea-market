<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\PseudoTypes\True_;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
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
            'description' => ['required', 'max:255'],
            'image' => ['required', 'mimes:png, jpeg'],
            'category' => ['required'],
            'condition' => ['required'],
            'price' => ['required', 'integer', 'min:0']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'image.required' => '商品画像をアップロードしてください',
            'category.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',
            'image.mimes' => '画像は.jpegもしくは.png形式でアップロードしてください',
            'price.integer' => '商品価格は整数で入力してください',
            'price.min' => '商品価格は0円以上で入力してください',
        ];
    }
}
