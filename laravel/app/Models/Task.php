<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'task',
        'date',
    ];

    public function itensTasks(): HasMany
    {
        return $this->hasMany(ItemsTask::class, 'task_id', 'id');
    }
}
