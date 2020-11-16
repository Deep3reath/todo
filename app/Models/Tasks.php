<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed title
 * @method static where(array $array)
 * @method static get()
 */
class Tasks extends Model
{
    public $timestamps = true;
    use HasFactory;

}
