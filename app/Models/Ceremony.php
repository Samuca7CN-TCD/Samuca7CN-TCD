<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ceremony extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'budget_id',
        'total_negotiated_amount',
        'paid_amount',
        'total_installments',
        'total_additions',
        'total_expenses',
        'total_discount',
        'status',
        'observations'
    ];

    public function budget()
    {
        return $this->hasOne(Budget::class);
    }

    public function ceremonyStatus()
    {
        return $this->hasOne(CeremonyStatus::class);
    }

    public function task()
    {
        return $this->hasMany(Task::class);
    }

    public function receipt()
    {
        return $this->hasMany(Receipt::class);
    }
}
