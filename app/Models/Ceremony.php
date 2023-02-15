<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ceremony extends Model
{
    use HasFactory;
    use SoftDeletes;

    function budget(){
        return $this->hasOne(Budget::class);
    }

    function task(){
        return $this->hasMany(Task::class);
    }

    function receipt(){
        return $this->hasMany(Receipt::class);
    }
}
