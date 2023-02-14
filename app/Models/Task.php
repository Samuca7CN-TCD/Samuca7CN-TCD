<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    function ceremony(){
        return $this->belongsTo(Ceremony::class);
    }

    function taskFather(){
        return $this->belongsTo(Task::class);
    }

    function subTask(){
        return $this->hasMany(Task::class);
    }

    function tag(){
        return $this->hasOne(Tag::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }

    function taskStatus(){
        return $this->hasOne(TaskStatus::class);
    }
}
