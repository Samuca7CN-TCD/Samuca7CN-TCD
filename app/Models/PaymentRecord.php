<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentRecord extends Model
{
    use HasFactory;
    use SoftDeletes;

    function installment(){
        return $this->belongsTo(Installment::class);
    }

    function voucher(){
        return $this->hasOne(Voucher::class);
    }
}
