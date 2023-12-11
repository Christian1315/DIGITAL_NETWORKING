<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "owner",
        "active"
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class, "store_id");
    }

    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class);
    }

    public function pos(): BelongsTo
    {
        return $this->belongsTo(Pos::class);
    }

    function supplies(): HasMany
    {
        return $this->hasMany(StoreSupply::class, "store");
    }

    function stocks(): HasMany
    {
        return $this->hasMany(StoreStock::class, "store")->with(["product"]);
    }
}
