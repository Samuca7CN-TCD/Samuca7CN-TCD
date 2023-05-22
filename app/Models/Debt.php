<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function accountingStatus(){
        return $this->hasOne(AccountingStatus::class);
    }

    public function contract(){
        return $this->hasMany(Contract::class);
    }
}
