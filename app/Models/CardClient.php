<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CardClient extends Model
{
    use HasFactory;

    protected $fillable = [
        "firstname",
        "lastname",
        "birthday",
        "country",
        "gender",
        "resid_adress",
        "city",
        "departement",
        "phone",
        "email",
        "piece",
        "piece_picture",
        "souscrib_form_picture",
        "card_type",
        "visible"
    ];

    function piece(): BelongsTo
    {
        return $this->belongsTo(Piece::class, "piece");
    }

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }

    function card_type(): BelongsTo
    {
        return $this->belongsTo(CardType::class, "card_type");
    }

    function card(): HasOne
    {
        return $this->hasOne(Card::class, "client")->with("rechargement");
    }
}
