<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CanalSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        "decodeur_num",
        "detail",
        "receipt",
        "payment_ref",
        "payment_amount",
        "payment_type",
        "payment_status",
        "payment_details",
        "session",
        "client",
        "manager",
        "agency",
        "option",
        "formule",
        "month",
        "amount",
        "status",
    ];

    function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, "manager");
    }

    function session(): BelongsTo
    {
        return $this->belongsTo(UserSession::class, "session");
    }

    function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, "client");
    }

    function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, "agency");
    }

    function option(): BelongsTo
    {
        return $this->belongsTo(CanalSubscriptionOption::class, "option");
    }

    function formule(): BelongsTo
    {
        return $this->belongsTo(CanalFormula::class, "formule");
    }

    function status(): BelongsTo
    {
        return $this->belongsTo(CanalSubscriptionStatus::class, "status");
    }
}
