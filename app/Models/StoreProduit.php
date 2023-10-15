<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreProduit extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "price",
        "description",
        "category",
        "store",
        "active",
        "product_type",
        "img"
    ];

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, "store")->with("pos");
    }

    function session(): BelongsTo
    {
        return $this->belongsTo(UserSession::class, "session");
    }

    function category(): BelongsTo
    {
        return $this->belongsTo(StoreCategory::class, "category");
    }

    function product_type(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, "product_type");
    }

    function product_stock(): BelongsTo
    {
        return $this->belongsTo(StoreStock::class, "product");
    }
}
