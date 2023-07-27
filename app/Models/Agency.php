<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "ifu",
        "rccm",
        "country",
        "commune",
        "phone",
        "email",
        "numero_piece",
        "comment",
        "domaine_activite",
        "type_piece",
        "type_id",
        "ifu_file",
        "rccm_file",
        "piece_file",
        "photo",
        "user_id",
        "number",
        "agent_dad"
    ];

    #ONE TO MANY RELATIONSHIP/INVERSE(UN MASTER PEUT CREER PLUSIEURS AGENCES)
    public function master(): BelongsTo
    {
        return $this->belongsTo(Master::class,'master_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class,"owner");
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agents(): HasMany
    {
        return $this->hasMany(Agent::class);
    }

    public function poss(): HasMany
    {
        return $this->hasMany(Pos::class,"owner");
    }

    public function agentDad(): HasOne
    {
        return $this->hasOne(Agent::class,'id');
    }
}
