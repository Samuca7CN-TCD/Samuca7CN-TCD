<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetAdditionalVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_additional_id',
        'name',
        'value',
        'file',
        'payment_date'
    ];
}
