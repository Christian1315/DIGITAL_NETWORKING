<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreFacturation extends Model
{
    use HasFactory;

    protected $fillable = [
        "this_client",
        "facturier",
        "facture",
        "reference",
        "command",
        "ticket"
    ];

    function _client(): BelongsTo
    {
        return $this->belongsTo(Client::class, "this_client");
    }

    function facturier(): BelongsTo
    {
        return $this->belongsTo(User::class, "facturier");
    }

    function _command(): BelongsTo
    {
        return $this->belongsTo(StoreCommand::class, "command")->with(["products"]);
    }
}
