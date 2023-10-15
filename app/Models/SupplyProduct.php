<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplyProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        "comments",
        "supply",
        "product",
        "quantity",
    ];

    // function session(): BelongsTo
    // {
    //     return $this->belongsTo(UserSession::class, "session");
    // }

    function product(): BelongsTo
    {
        return $this->belongsTo(StoreProduit::class, "product");
    }
}
