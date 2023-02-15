<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    function debt(){
        return $this->belongsTo(Debt::class);
    }

    function accountingStatus(){
        return $this->hasOne(AccountingStatus::class);
    }

    function voucher(){
        return $this->hasMany(Voucher::class);
    }
}
