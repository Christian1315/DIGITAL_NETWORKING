<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreCommand extends Model
{
    use HasFactory;

    protected $fillable = [
        "store",
        "product",
        "table",
        "qty",
        "amount",
        "owner",
        "session",
        "client"
    ];

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, "store");
    }

    function product(): BelongsTo
    {
        return $this->belongsTo(StoreProduit::class, "product");
    }

    function product_datas(): BelongsTo
    {
        return $this->belongsTo(StoreProduit::class, "product")->withDefault(["name","price"]);
    }

    function table(): BelongsTo
    {
        return $this->belongsTo(StoreTable::class, "table");
    }
    function session(): BelongsTo
    {
        return $this->belongsTo(UserSession::class, "session");
    }
}
