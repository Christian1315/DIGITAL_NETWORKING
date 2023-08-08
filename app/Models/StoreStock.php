<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreStock extends Model
{
    use HasFactory;

    protected $fillable = [
        // "session"
    ];

    function product(): BelongsTo
    {
        return $this->belongsTo(StoreProduit::class, "product");
    }

    function store(): BelongsTo
    {
        return $this->belongsTo(StoreProduit::class, "store");
    }
}
