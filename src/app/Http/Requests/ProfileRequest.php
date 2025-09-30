<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'name' => ['required', 'max:20', Rule::unique('users', 'name')->ignore($this->user()->id)],
            'profile_image' => 'file|mimes:jpeg,png',
            'postal_code' => 'required|string|regex:/^[0-9]{3}-[0-9]{4}$/',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名を入力してください',
            'name.unique' => '既に同じ名前のユーザーがいます',
            'name.max' => '20文字以内で入力してください',
            'profile_image.file' => 'アップロードできるファイル形式が異なります',
            'profile_image.mimes' => 'プロフィール画像は.jpegか.pngでアップロードしてください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号はハイフンを含めた半角８文字で入力してください',
            'address.required' => '住所を入力してください'
        ];
    }
}
