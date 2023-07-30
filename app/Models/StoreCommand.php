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
        "amount"
    ];

    function owner() : BelongsTo {
        return $this->belongsTo(User::class,"owner");
    }

    function store() : BelongsTo {
        return $this->belongsTo(Store::class,"store");
    }

    function product() : BelongsTo {
        return $this->belongsTo(StoreProduit::class,"owner");
    }

    function table() : BelongsTo {
        return $this->belongsTo(StoreTable::class,"table");
    }
}
