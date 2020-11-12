<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestTask extends FormRequest
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

    public function messages()
    {
        return [
            'required' => 'Поле `:attribute` должно быть заполнено.',
            'max' => 'Максимальная длина поля `:attribute`, 128 символов.',
            'unique' => 'Такая задача уже существует.'
        ];
    }
    public function attributes()
    {
        return [
            'title' => 'Задача',
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:127|unique:tasks'
        ];
    }
}
