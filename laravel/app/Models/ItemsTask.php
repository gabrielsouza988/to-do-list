<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemsTask extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'items_task';

    protected $fillable = [
        'task_id',
        'task',
        'date_execution',
        'status'
    ];

    public function task(): HasOne
    {
        return $this->hasOne(Task::class, 'id', 'task_id');
    }
}
