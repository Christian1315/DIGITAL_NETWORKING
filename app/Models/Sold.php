<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sold extends Model
{
    use HasFactory;


    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, "agency");
    }

    function module(): BelongsTo
    {
        return $this->belongsTo(Module::class, "module");
    }

    function status(): BelongsTo
    {
        return $this->belongsTo(SoldStatus::class, "status");
    }

    function pos(): BelongsTo
    {
        return $this->belongsTo(Pos::class, "pos");
    }
    function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, "manager");
    }

    function manager_with_name(): BelongsTo
    {
        return $this->belongsTo(User::class, "manager")->withDefault("firstname");
    }
}
