<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pos extends Model
{
    use HasFactory;

    protected $fillable = [
        "username",
        "country",
        "phone",
        "pos_id"
    ];


    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner');
    }

    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class,);
    }

    public function agencies(): BelongsTo
    {
        return $this->belongsTo(Agency::class, "agency_id");
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class, "pos_id");
    }

    public function sold(): HasOne
    {
        return $this->hasOne(Sold::class, "pos");
    }
}
