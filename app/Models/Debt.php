<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model
{
    use HasFactory;
    use SoftDeletes;

    function department(){
        return $this->belongsTo(Department::class);
    }

    function accountingStatus(){
        return $this->hasOne(AccountingStatus::class);
    }

    function contract(){
        return $this->hasMany(Contract::class);
    }
}
