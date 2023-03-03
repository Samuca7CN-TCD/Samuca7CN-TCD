<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountingStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "accounting_status";

    public function debt(){
        return $this->belongsToMany(Debt::class);
    }

    public function contract(){
        return $this->belongsToMany(Contract::class);
    }
}
