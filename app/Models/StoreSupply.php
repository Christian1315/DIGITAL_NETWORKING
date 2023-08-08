<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreSupply extends Model
{
    use HasFactory;

    protected $fillable = [
        'comments',
        'store',
        'pos',
        'status',
        'visible',
    ];

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner');
    }

    function pos(): BelongsTo
    {
        return $this->belongsTo(Pos::class, "pos");
    }

    function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, "store");
    }

    function supply_products(): HasMany
    {
        return $this->hasMany(SupplyProduct::class, "supply");
    }
}
