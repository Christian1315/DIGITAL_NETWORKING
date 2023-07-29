<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "active"
    ];

    public function owner() : BelongsTo {
        return $this->belongsTo(User::class,"owner");
    }
}
