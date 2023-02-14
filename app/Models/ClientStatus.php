<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "client_status";

    function client()
    {
        return $this->belongsToMany(Client::class);
    }
}
