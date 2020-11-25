<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed title
 * @method static where(array $array)
 */
class Tasks extends Model
{
    public $timestamps = true;
    use HasFactory;

    public $fillable = ['title'];
    public $messages = [
        'required' => 'Поле `:attribute` должно быть заполнено.',
        'max' => 'Максимальная длина поля `:attribute`, 128 символов.',
        'unique' => 'Такая задача уже существует.',
    ];

    public $attributes = [
        'title' => 'Задача'
    ];
    public $rules = [
        ['title' => 'required|unique:tasks|max:255'],
    ];
}
