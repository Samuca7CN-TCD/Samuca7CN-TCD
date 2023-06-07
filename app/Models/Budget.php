<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'client_id',
        'event_id',
        'decoration_id',
        'buffet_entry_id',
        'buffet_id',
        'beer',
        'bar',
        'dj',
        'advisory',
        'additional_meat',
        'ravioli',
        'additional_drinks',
        'other_beers',
        'guests_quantity',
        'event_date',
        'event_time',
        'event_place',
        'budget_total_value',
        'status',
        'budget_comment',
        'budget_token',
        'budget_link',
    ];

    public function event()
    {
        return $this->hasOne(Event::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function decoration()
    {
        return $this->hasOne(Decoration::class);
    }

    public function buffetEntry()
    {
        return $this->hasOne(BuffetEntry::class);
    }

    public function buffet()
    {
        return $this->hasOne(Buffet::class);
    }

    public function ceremony()
    {
        return $this->belongsTo(Ceremony::class);
    }
}
