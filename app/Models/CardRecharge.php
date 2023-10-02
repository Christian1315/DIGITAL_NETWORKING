<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardRecharge extends Model
{
    use HasFactory;

    protected $fillable = [
        "card_id",
        "card_num",
        "card_type",
        "client",
        "amount",
        "frais_amount",
        "amount_to_pay",
    ];

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    function status(): BelongsTo
    {
        return $this->belongsTo(CardRechargeStatus::class, "status");
    }

    function card(): BelongsTo
    {
        return $this->belongsTo(Card::class, "card");
    }

    function client(): BelongsTo
    {
        return $this->belongsTo(CardClient::class, "client");
    }
}
