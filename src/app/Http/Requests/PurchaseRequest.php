<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment' => 'required',
            'postal_code' => 'required|string|regex:/^[0-9]{3}-[0-9]{4}$/',
            'address' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'payment.required' => '支払い方法を選択してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号はハイフンを含めた半角８文字で入力してください',
            'address.required' => '送付先の住所を設定してください'
        ];
    }
}
