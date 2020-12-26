<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find()
 * @method static where(array $array)
 * @method static get()
 */
class Task extends Model
{
    use HasFactory;

    public $fillable = [
      'title', 'user_id'
    ];
}
