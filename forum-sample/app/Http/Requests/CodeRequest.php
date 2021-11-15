<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeRequest extends FormRequest
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
            'kind' => 'required|integer',
            'sort' => 'required|integer|between:1,99',
            'name' => 'required|max:100',
        ];
    }

    public function messages() {
        return [
            'kind.required' => '種別は入力必須です',
            'kind.integer' => '種別は整数で入力してください',
            'sort.required' => 'ソートは入力必須です',
            'sort.integer' => 'ソートは整数で入力してください',
            'sort.between' => 'ソートは1～99の整数を指定してください',
            'name.required' => '名称は入力必須です',
            'name.max' => '名称は100文字以内で入力してください'
        ];
    }
}
