<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function event(){
        return $this->hasOne(Event::class);
    }

    public function client(){
        return $this->hasOne(Client::class);
    }

    public function decoration(){
        return $this->hasOne(Decoration::class);
    }

    public function buffetEntry(){
        return $this->hasOne(BuffetEntry::class);
    }

    public function buffet(){
        return $this->hasOne(Buffet::class);
    }

    public function ceremony(){
        return $this->belongsTo(Ceremony::class);
    }
}
