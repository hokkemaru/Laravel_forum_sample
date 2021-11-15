<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumRequest extends FormRequest
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
            'title' => 'required|max:255',
            'category' => 'required',
            'text' => 'required|max:16383',
        ];
    }

    public function messages() {
        return [
            'title.required' => 'タイトルを入力してください',
            'title.max' => 'タイトルは255文字以内で入力してください',
            'category.required' => 'カテゴリを選択してください',
            'text.required' => '本文を入力してください',
            'text.max' => '本文は16,383文字以内で入力してください',
        ];
    }
}
