<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExhibitionRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required|max:255',
            'item_image' => 'required|file|mimes:jpeg,png',
            'categories' => 'required|array|min:1|max:3',
            'condition' => ['required', Rule::in(['良好', '目立った傷や汚れなし', 'やや傷や汚れあり', '状態が悪い'])],
            'price' => 'required|integer|min:0'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '255文字以内で入力してください',
            'item_image.required' => '商品画像を選択してください',
            'item_image.file' => 'アップロードできるファイル形式が異なります',
            'item_image.mimes' => 'プロフィール画像は.jpegか.pngでアップロードしてください',
            'categories.required' => 'カテゴリーを選択してください',
            'categories.max' => 'カテゴリーは最大３つまで選択可能です',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は半角数字で入力してください',
            'price.min' => '販売価格は0円以上で入力してください'
        ];
    }
}
