<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ceremony_id',
        'tags',
        'user_id',
        'task_status_id',
        'title',
        'deadline',
        'description',
        'priority',
    ];

    
    public function ceremony(){
        return $this->belongsTo(Ceremony::class);
    }

    public function taskFather(){
        return $this->belongsTo(Task::class);
    }

    public function subTask(){
        return $this->hasMany(Task::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function taskStatus(){
        return $this->hasOne(TaskStatus::class);
    }

    public function comment(){
        return $this->hasOne(Comment::class);
    }

    public function user_operation(){
        return $this->belongsToMany(User::class);
    }
}
