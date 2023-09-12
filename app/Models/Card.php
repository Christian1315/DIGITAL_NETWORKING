<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        "card_id",
        "card_num",
        "type",
        "expire_date"
    ];

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    function status(): BelongsTo
    {
        return $this->belongsTo(CardStatus::class, "status");
    }

    function client(): BelongsTo
    {
        return $this->belongsTo(CardClient::class, "client");
    }

    function type(): BelongsTo
    {
        return $this->belongsTo(CardType::class, "type");
    }

    function agency()
    {
        return $this->belongsTo(Agency::class, "agency");
    }
}
