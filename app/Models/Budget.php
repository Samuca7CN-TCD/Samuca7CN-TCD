<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;

    function event(){
        return $this->hasOne(Event::class);
    }

    function client(){
        return $this->hasOne(Client::class);
    }

    function decoration(){
        return $this->hasOne(Decoration::class);
    }

    function buffetEntry(){
        return $this->hasOne(BuffetEntry::class);
    }

    function buffet(){
        return $this->hasOne(Buffet::class);
    }

    function ceremony(){
        return $this->belongsTo(Ceremony::class);
    }
}
