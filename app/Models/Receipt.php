<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function ceremony(){
        return $this->belongsTo(Ceremony::class);
    }

    public function installment(){
        return $this->hasMany(Installment::class);
    }
}
