<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    use HasFactory;
    use SoftDeletes;

    function receipt(){
        return $this->belongsTo(Receipt::class);
    }

    function paymentRecord(){
        return $this->hasMany(PaymentRecord::class);
    }
}
