<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'email',
        'piece',
        'type_piece',
        'adresse',
        'birthday',
        'sexe',
        'owner'
    ];

    function type_piece(): BelongsTo
    {
        return $this->belongsTo(Piece::class, "type_piece");
    }

    function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, "owner");
    }
}
