<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find()
 * @method static where(array $array)
 * @method static get()
 * @method static paginate(int $int)
 * @method orderBy(string $string, string $string1)
 * @property mixed subtasks
 */
class Task extends Model
{
    use HasFactory;
    public $timestamps = true;
    public $fillable = [
      'title', 'user_id', 'subtasks'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function decodeSubtasks()
    {
        $this->subtasks = json_decode($this->subtasks, true);
    }
}
