<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CeremonyStatus extends Model
{
    use HasFactory;

    protected $table = "ceremony_status";

    public function ceremony(){
        return $this->belongsToMany(Ceremony::class);
    }
}
