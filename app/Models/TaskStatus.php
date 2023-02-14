<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "task_status";

    function task(){
        return $this->belongsToMany(Task::class);
    }
}
