<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
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
