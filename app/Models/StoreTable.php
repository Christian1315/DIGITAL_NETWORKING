<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreTable extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "capacity",
        "store",
        "status"
    ];

    function owner(): BelongsTo {
        return $this->belongsTo(User::class,"owner");
    }
}
