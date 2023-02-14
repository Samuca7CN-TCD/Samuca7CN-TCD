<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    function clientStatus(){
        return $this->hasOne(ClientStatus::class);
    }

    function budget(){
        return $this->belongsToMany(Budget::class);
    }
}
