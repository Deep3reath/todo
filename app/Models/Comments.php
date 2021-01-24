<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(array $array)
 */
class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id', 'task_id', 'content'
    ];
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
