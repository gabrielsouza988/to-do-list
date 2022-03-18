<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'task',
        'date',
    ];

    public function secondaryTasks(): HasMany
    {
        return $this->hasMany(SecondaryTask::class, 'task_id', 'id');
    }
}
