<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'ceremony_id',
        'name',
        'amount'
    ];
}
