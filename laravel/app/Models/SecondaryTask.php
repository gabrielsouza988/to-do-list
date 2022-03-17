<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SecondaryTask extends Model
{
    use SoftDeletes;
    protected $table = 'secondary_task';

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
