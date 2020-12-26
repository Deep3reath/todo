<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TaskRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:2|max:31|unique:tasks,title,NULL,id,user_id,'.Auth::user()->id
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Задача',
            'user_id' => 'Пользователь'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Заполните `:attribute.`',
            'min' => 'Минимальная длина `:attribute` - :min символа',
            'max' => 'Максимальная длина `:attribute` - :max символ',
            'unique' => '`:attribute` должен быть уникальным',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException (
            response()->json(['validationMessage' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE));

    }
}
