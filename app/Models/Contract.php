<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function debt(){
        return $this->belongsTo(Debt::class);
    }

    public function accountingStatus(){
        return $this->hasOne(AccountingStatus::class);
    }

    public function voucher(){
        return $this->hasMany(Voucher::class);
    }
}
