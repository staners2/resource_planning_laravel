<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'min:5',
            'article' => 'min:5|regex:/^[a-zA-z0-9]+$/',
        ];
    }

    public function messages()
    {
        return [
            'min' => ':attribute должен быть больше :min символов',
            'article.regex' => ':attribute должен содержать только цифры и латинские символы',
        ];
    }
}
