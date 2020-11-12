<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed title
 */
class Tasks extends Model
{
    public $timestamps = true;
    use HasFactory;

}
