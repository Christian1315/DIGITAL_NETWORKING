<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        "product_classe",
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

    function classe_product(): BelongsTo
    {
        return $this->belongsTo(ProductClasse::class, "product_classe");
    }

    function product_stock(): HasOne
    {
        return $this->hasOne(StoreStock::class, "product")->where(["visible" => 1]);
    }

    function commands(): BelongsTo
    {
        return $this->belongsTo(StoreCommand::class, "commands_products", "command_id", "product_id");
    }
}
