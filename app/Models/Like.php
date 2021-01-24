<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(array $array)
 */
class Like extends Model
{
    protected $table = 'like';
    public $timestamps = true;

    protected $fillable = [
      'user_id', 'task_id'
    ];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
