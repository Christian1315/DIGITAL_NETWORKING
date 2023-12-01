<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreRapport extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     "session",
    //     "rapport"
    // ];

    function this_session() : BelongsTo {
        return $this->belongsTo(UserSession::class,"session");
    }

    function owner() : BelongsTo {
        return $this->belongsTo(User::class,"owner");
    }
}
