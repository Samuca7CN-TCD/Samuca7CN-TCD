<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuffetPlate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'status',
        'name',
        'description',
        'qtd_per_ten_people',
        'measure_unity',
        'cost',
        'buffet_id',
    ];
}
